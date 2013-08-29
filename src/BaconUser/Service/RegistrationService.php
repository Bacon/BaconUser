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
use BaconUser\Form\RegistrationForm;
use BaconUser\Options\UserOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;

/**
 * Service managing the registration of users.
 */
class RegistrationService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

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
     * @throws Exception\UnexpectedValueException
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

        // Trigger an event so that we can send an email, for instance
        $this->getEventManager()->trigger(new RegistrationEvent($user));

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

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
