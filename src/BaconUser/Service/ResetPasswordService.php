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

/**
 * Service that allows to generate and verify reset passwords
 */
class ResetPasswordService implements EventManagerAwareInterface
{
    /**
     * Event names
     */
    const EVENT_RESET_PASSWORD_CREATED = 'resetPasswordCreated';

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
     * @param ObjectManager                 $objectManager
     * @param ObjectRepository              $resetPasswordRepository
     * @param ResetPasswordOptionsInterface $resetPasswordOptions
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $resetPasswordRepository,
        ResetPasswordOptionsInterface $resetPasswordOptions
    ) {
        $this->objectManager           = $objectManager;
        $this->resetPasswordRepository = $resetPasswordRepository;
        $this->resetPasswordOptions    = $resetPasswordOptions;
    }

    /**
     * Create a new reset password request for a given email, and saves it to the database
     *
     * @param  string $email
     * @return ResetPassword
     */
    public function createResetPasswordRequest($email)
    {
        $resetPassword = new ResetPassword();
        $resetPassword->setEmail($email)
                      ->setToken(sha1(uniqid() . $email));

        $now              = new DateTime();
        $validityInterval = $this->resetPasswordOptions->getTokenValidityInterval();

        $resetPassword->setExpirationDate($now->add($validityInterval));

        $this->objectManager->persist($resetPassword);
        $this->objectManager->flush();

        // Trigger an event so that user can send a mail to the user in response
        $this->eventManager->trigger(self::EVENT_RESET_PASSWORD_CREATED, null, array(
            'resetPassword' => $resetPassword
        ));

        return $resetPassword;
    }

    /**
     * Check if a token is valid for a given email. This checks among other tings the time expiration. This
     * method should be called before allowing the user to restore a new password to prevent unwanted reset
     *
     * @param  string $email
     * @param  string $token
     * @throws Exception\InvalidArgumentException
     * @return bool
     */
    public function isTokenValid($email, $token)
    {
        $className = $this->resetPasswordRepository->getClassName();

        if (is_subclass_of($className, 'BaconUser\Entity\ResetPassword')) {
            throw new Exception\InvalidArgumentException(sprintf(
                'An invalid repository was given in %s',
                __CLASS__
            ));
        }

        /** @var ResetPassword|null $resetPassword */
        $resetPasswords = $this->resetPasswordRepository->findBy(array('email' => $email));

        $now = new DateTime();

        foreach ($resetPassword as $resetPassword) {
            if ($resetPassword->getExpirationDate() > $now && Utils::compareStrings($resetPassword->getToken(), $token)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->eventManager = new EventManager();
        }

        return $this->eventManager;
    }
}
