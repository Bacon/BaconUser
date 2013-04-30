<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Password\HandlerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
        if ($serviceLocator instanceof AbstractPluginManager) {
            $config = $serviceLocator->getServiceLocator()->get('Config');
        } else {
            $config = array();
        }

        if (isset($config['bacon_user']['password']['handler_manager'])) {
            $managerConfig = new ServiceManagerConfig($config['bacon_user']['password']['handler_manager']);
        } else {
            $managerConfig = null;
        }

        return new HandlerManager($managerConfig);
    }
}
