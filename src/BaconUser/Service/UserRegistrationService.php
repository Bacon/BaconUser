<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\UserInterface;
use BaconUser\Exception;
use BaconUser\Options\UserOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\FormInterface;

class UserRegistrationService
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
        $userEntityClass = $this->options->getUserEntityClass();

        $this->registrationForm->bind(new $userEntityClass());
        $this->registrationForm->setData($data);

        if (!$this->registrationForm->isValid()) {
            return null;
        }

        $user = $this->registrationForm->getData();

        if (!$user instanceof UserInterface) {
            throw new Exception\UnexpectedValueException('Received user is not an instance of BaconUser\Entity\UserInterface');
        }

        if ($this->options->getEnableUserState()) {
            $user->setState($this->options->getDefaultUserState());
        }

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }
}
