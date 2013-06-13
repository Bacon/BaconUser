<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service\Factory;

use BaconUser\Service\ResetPasswordService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see ResetPasswordService}.
 */
class ResetPasswordServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ResetPasswordService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resetPasswordService = new ResetPasswordService(
            $serviceLocator->get('BaconUser\ObjectManager'),
            $serviceLocator->get('BaconUser\Repository\ResetPasswordRepository'),
            $serviceLocator->get('BaconUser\Options\ResetPasswordOptions')
        );

        return $resetPasswordService;
    }
}
