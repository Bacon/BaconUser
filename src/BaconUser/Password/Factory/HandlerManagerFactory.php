<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password\Factory;

use BaconUser\Password\HandlerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Config;

/**
 * Service factory that instantiates {@see HandlerManager}.
 */
class HandlerManagerFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return HandlerAggregate
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('BaconUser\Config');

        if (isset($config['password']['handler_manager'])) {
            $managerConfig = new Config($config['password']['handler_manager']);
        } else {
            $managerConfig = null;
        }

        return new HandlerManager($managerConfig);
    }
}
