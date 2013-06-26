<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\User;
use BaconUser\Entity\UserInterface;
use BaconUser\Exception;
use BaconUser\Options\UserOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\FormInterface;

/**
 * Service managing the registration of users.
 */
class RegistrationService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var UserOptionsInterface
     */
    protected $options;

    /**
     * @var UserInterface
     */
    protected $userPrototype;

    /**
     * @param UserOptionsInterface $options
     * @param ObjectManager        $objectManager
     */
    public function __construct(ObjectManager $objectManager, UserOptionsInterface $options)
    {
        $this->objectManager = $objectManager;
        $this->options       = $options;
    }

    /**
     * Registers a new user.
     *
     * @param  UserInterface $user
     * @return null|UserInterface
     */
    public function register(UserInterface $user)
    {
        if ($this->options->getEnableUserState()) {
            $user->setState($this->options->getDefaultUserState());
        }

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }

    /**
     * @return UserInterface
     */
    public function getUserPrototype()
    {
        if ($this->userPrototype === null) {
            $this->setUserPrototype(new User());
        }

        return $this->userPrototype;
    }

    /**
     * @param  UserInterface $userPrototype
     * @return RegistrationService
     */
    public function setUserPrototype(UserInterface $userPrototype)
    {
        $this->userPrototype = $userPrototype;
        return $this;
    }
}
