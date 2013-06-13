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
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

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
     * @var ResetPasswordOptionsInterface
     */
    protected $resetPasswordOptions;

    /**
     * @param ObjectManager                 $objectManager
     * @param ResetPasswordOptionsInterface $resetPasswordOptions
     */
    public function __construct(ObjectManager $objectManager, ResetPasswordOptionsInterface $resetPasswordOptions)
    {
        $this->objectManager        = $objectManager;
        $this->resetPasswordOptions = $resetPasswordOptions;
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

        $now              = new DateTime('now');
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
     * @throws Exception\NotFoundException
     * @return bool
     */
    public function isTokenValid($email, $token)
    {
        /** @var \BaconUser\Entity\ResetPassword $resetPassword */
        $resetPassword = $this->objectManager->getRepository('BaconUser\Entity\ResetPassword')
                                             ->findOneBy(array('email' => $email, 'token' => $token));

        if (null === $resetPassword) {
            throw Exception\NotFoundException::notFoundResetPasswordEntity($email, $token);
        }

        $now = new DateTime('now');

        if ($resetPassword->getExpirationDate() > $now) {
            return false;
        }

        return true;
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
