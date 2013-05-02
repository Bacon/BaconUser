<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Options\PasswordHandlerAggregateOptions;
use BaconUser\Password\HandlerAggregate;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see HandlerAggregate}.
 */
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
        $aggregate->setHandlerManager($serviceLocator->get('BaconUser\Password\HandlerManager'));

        $config = $serviceLocator->get('BaconUser\Config');

        if (isset($config['password']['handler_aggregate'])) {
            $options = new PasswordHandlerAggregateOptions(
                $config['password']['handler_aggregate']
            );

            $aggregate->setOptions($options);
        }

        return $aggregate;
    }
}
