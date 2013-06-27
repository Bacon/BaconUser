<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Hydrator\Factory;

use BaconUser\Form\PasswordHashingStrategy;
use BaconUser\Hydrator\RegistrationHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationHydrator}.
 */
class RegistrationHydratorFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $parentLocator = $serviceLocator->getServiceLocator();

        $hydrator = new RegistrationHydrator(
            new PasswordHashingStrategy(
                $parentLocator->get('BaconUser\Password\HandlerInterface')
            )
        );

        return $hydrator;
    }
}
