<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service\Factory;

use BaconUser\Service\RegistrationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationService}.
 */
class RegistrationServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $registrationService = new RegistrationService(
            $serviceLocator->get('BaconUser\Form\User\RegistrationForm'),
            $serviceLocator->get('BaconUser\ObjectManager'),
            $serviceLocator->get('BaconUser\Options\UserOptions')
        );

        $registrationService->setUserPrototype($serviceLocator->get('BaconUser\Entity\UserPrototype'));

        return $registrationService;
    }
}
