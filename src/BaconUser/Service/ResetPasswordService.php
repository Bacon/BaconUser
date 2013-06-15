<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\ResetPassword;
use BaconUser\Exception;
use BaconUser\Options\ResetPasswordOptionsInterface;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Crypt\Utils;
use Zend\Math;

/**
 * Service that allows to generate and verify reset passwords
 */
class ResetPasswordService implements EventManagerAwareInterface
{
    /**
     * Valid characters for token generation
     */
    const HASH_CHAR_LIST = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $resetPasswordRepository;

    /**
     * @var ResetPasswordOptionsInterface
     */
    protected $resetPasswordOptions;

    /**
     * @param  ObjectManager                 $objectManager
     * @param  ObjectRepository              $resetPasswordRepository
     * @param  ResetPasswordOptionsInterface $resetPasswordOptions
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $resetPasswordRepository,
        ResetPasswordOptionsInterface $resetPasswordOptions
    ) {
        $this->objectManager           = $objectManager;
        $this->resetPasswordRepository = $resetPasswordRepository;
        $this->resetPasswordOptions    = $resetPasswordOptions;

        // Check that the repository handles the right entity
        $className = $this->resetPasswordRepository->getClassName();

        if (is_subclass_of($className, 'BaconUser\Entity\ResetPassword')) {
            throw new Exception\InvalidArgumentException(sprintf(
                'An invalid repository was given in %s',
                __CLASS__
            ));
        }
    }

    /**
     * Create a new reset password request for a given email, and saves it to the database
     *
     * @param  string $email
     * @return ResetPassword
     */
    public function createResetPasswordRequest($email)
    {
        // We first check if a token already exists for the given mail, so that we can reuse it
        $resetPassword = $this->resetPasswordRepository->findOneBy(array('email' => $email));

        if (null === $resetPassword) {
            $resetPassword = new ResetPassword();
            $resetPassword->setEmail($email);
        }

        // If the token does not exist OR has expired (which is the case when the same reset password
        // request is reused)
        if ($resetPassword->hasTokenExpired()) {
            $resetPassword->setToken(Math\Rand::getString(24, static::HASH_CHAR_LIST));
        }

        $now              = new DateTime();
        $validityInterval = $this->resetPasswordOptions->getTokenValidityInterval();

        $resetPassword->setExpirationDate($now->add($validityInterval));

        $this->objectManager->persist($resetPassword);
        $this->objectManager->flush();

        // Trigger an event so that user can send a mail to the user in response
        $this->eventManager->trigger(new ResetPasswordEvent($resetPassword));

        return $resetPassword;
    }

    /**
     * Check if a token is valid for a given email
     *
     * This checks among other tings the time expiration. This method should be called before allowing
     * the user to restore a new password to prevent unwanted reset
     *
     * @param  string $email
     * @param  string $token
     * @return bool
     */
    public function isTokenValid($email, $token)
    {
        /** @var ResetPassword|null $resetPassword */
        $resetPassword = $this->resetPasswordRepository->findOneBy(array('email' => $email));

        if (null === $resetPassword) {
            return false;
        }

        if (!$resetPassword->hasTokenExpired() && Utils::compareStrings($resetPassword->getToken(), $token)) {
            return true;
        }

        return false;
    }

    /**
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class()
        ));

        $this->eventManager = $eventManager;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->eventManager = new EventManager();
        }

        return $this->eventManager;
    }
}
