<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;


use BaconUser\Form\PasswordHashingStrategy;
use BaconUser\Form\RegistrationFormHydrator;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationFormHydrator}.
 */
class RegistrationFormHydratorFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationFormHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RegistrationFormHydrator(
            true,
            new PasswordHashingStrategy(
                $serviceLocator->get('BaconUser\Password\HandlerInterface')
            )
        );
    }
}
