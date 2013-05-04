<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form\Factory;

use BaconUser\Form\PasswordHashingStrategy;
use BaconUser\Form\RegistrationFilter;
use BaconUser\Form\RegistrationForm;
use BaconUser\Form\RegistrationHydrator;
use DoctrineModule\Validator\NoObjectExists;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationForm}.
 */
class RegistrationFormFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('BaconUser\Options\UserOptions');

        $hydrator = new RegistrationHydrator(
            new PasswordHashingStrategy($serviceLocator->get('BaconUser\Password\HandlerInterface'))
        );

        $userRepository = $serviceLocator->get('BaconUser\EntityManager')->getRepository(
            $options->getUserEntityClass()
        );

        $inputFilter = new RegistrationFilter(
            new NoObjectExists(array(
                'object_repository' => $userRepository,
                'fields'            => 'email',
            )),
            new NoObjectExists(array(
                'object_repository' => $userRepository,
                'fields'            => 'username',
            )),
            $options
        );

        $form = new RegistrationForm($options);
        $form->setHydrator($hydrator);
        $form->setInputFilter($inputFilter);

        return $form;
    }
}
