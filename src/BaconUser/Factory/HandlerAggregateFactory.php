<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Password\HandlerAggregate;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HandlerAggregateFactory implements FactoryInterface
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
        $aggregate = new HandlerAggregate();
        $aggregate->setHandlerManager($serviceLocator->get('baconuser_password_handlermanager'));

        if ($serviceLocator instanceof AbstractPluginManager) {
            $config = $serviceLocator->getServiceLocator()->get('Config');
        } else {
            $config = array();
        }

        if (isset($config['bacon_user']['password']['handler_aggregate'])) {
            $config = $config['bacon_user']['password']['handler_aggregate'];

            if (isset($config['hashing_methods'])) {
                $aggregate->setHashingMethods($config['hashing_methods']);
            }

            if (isset($config['default_hashing_method'])) {
                $aggregate->setDefaultHashingMethod($config['default_hashing_method']);
            }

            if (isset($config['migrate_to_default_hashing_method'])) {
                $aggregate->setMigrateToDefaultHashingMethod($config['migrate_to_default_hashing_method']);
            }
        }

        return $aggregate;
    }
}
