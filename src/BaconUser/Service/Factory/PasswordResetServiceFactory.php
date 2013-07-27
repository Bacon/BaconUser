<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service\Factory;

use BaconUser\Service\PasswordResetService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see PasswordResetService}.
 */
class PasswordResetServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PasswordResetService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $passwordResetService = new PasswordResetService(
            $serviceLocator->get('BaconUser\ObjectManager'),
            $serviceLocator->get('BaconUser\Repository\UserRepository'),
            $serviceLocator->get('BaconUser\Repository\PasswordResetRepository'),
            $serviceLocator->get('BaconUser\Options\PasswordResetOptions')
        );

        return $passwordResetService;
    }
}
