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
     * @var RegistrationForm
     */
    protected $registrationForm;

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
     * @param FormInterface        $registrationForm
     * @param UserOptionsInterface $options
     * @param ObjectManager        $objectManager
     */
    public function __construct(
        FormInterface $registrationForm,
        ObjectManager $objectManager,
        UserOptionsInterface $options
    ) {
        $this->registrationForm = $registrationForm;
        $this->objectManager    = $objectManager;
        $this->options          = $options;
    }

    /**
     * Registers a new user.
     *
     * @param  array $data
     * @return null|UserInterface
     */
    public function register(array $data)
    {
        $this->registrationForm->bind(clone $this->getUserPrototype());
        $this->registrationForm->setData($data);

        if (!$this->registrationForm->isValid()) {
            return null;
        }

        $user = $this->registrationForm->getData();

        if (!$user instanceof UserInterface) {
            throw Exception\UnexpectedValueException::invalidUserEntity($user);
        }

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
