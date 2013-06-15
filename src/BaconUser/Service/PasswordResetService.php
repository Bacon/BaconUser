<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\PasswordResetRequest;
use BaconUser\Exception;
use BaconUser\Options\PasswordResetOptionsInterface;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Crypt\Utils;
use Zend\Math;

/**
 * Service that allows to generate and verify reset password requests
 */
class PasswordResetService implements EventManagerAwareInterface
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
    protected $passwordResetRepository;

    /**
     * @var PasswordResetOptionsInterface
     */
    protected $passwordResetOptions;

    /**
     * @param  ObjectManager                 $objectManager
     * @param  ObjectRepository              $passwordResetRepository
     * @param  PasswordResetOptionsInterface $passwordResetOptions
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $passwordResetRepository,
        PasswordResetOptionsInterface $passwordResetOptions
    ) {
        $this->objectManager           = $objectManager;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->passwordResetOptions    = $passwordResetOptions;

        // Check that the repository handles the right entity
        $className = $this->passwordResetRepository->getClassName();

        if (is_subclass_of($className, 'BaconUser\Entity\PasswordResetRequest')) {
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
     * @return PasswordResetRequest
     */
    public function createResetPasswordRequest($email)
    {
        // We first check if a token already exists for the given mail, so that we can reuse it
        $passwordReset = $this->passwordResetRepository->findOneBy(array('email' => $email));

        if (null === $passwordReset) {
            $passwordReset = new PasswordResetRequest();
            $passwordReset->setEmail($email);
        }

        // If the token does not exist OR has expired (which is the case when the same reset password
        // request is reused)
        if ($passwordReset->hasTokenExpired()) {
            $passwordReset->setToken(Math\Rand::getString(24, static::HASH_CHAR_LIST));
        }

        $now              = new DateTime();
        $validityInterval = $this->passwordResetOptions->getTokenValidityInterval();

        $passwordReset->setExpirationDate($now->add($validityInterval));

        $this->objectManager->persist($passwordReset);
        $this->objectManager->flush();

        // Trigger an event so that user can send a mail to the user in response
        $this->eventManager->trigger(new PasswordResetEvent($passwordReset));

        return $passwordReset;
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
        /** @var PasswordResetRequest|null $resetPassword */
        $passwordReset = $this->passwordResetRepository->findOneBy(array('email' => $email));

        if (null === $passwordReset) {
            return false;
        }

        if (!$passwordReset->hasTokenExpired() && Utils::compareStrings($passwordReset->getToken(), $token)) {
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
