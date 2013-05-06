<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password\Factory;

use BaconUser\Password\Factory\HandlerAggregateFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Password\Factory\HandlerAggregateFactory
 */
class HandlerAggregateFactoryTest extends TestCase
{
    public function testFactoryWithoutConfig()
    {
        $handlerManager = $this->getMock('BaconUser\Password\HandlerManager');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Password\HandlerManager', $handlerManager);
        $locator->setService('BaconUser\Config', array());

        $factory = new HandlerAggregateFactory();
        $this->assertInstanceOf('BaconUser\Password\HandlerAggregate', $factory->createService($locator));
    }

    public function testFactoryWithConfig()
    {
        $handlerManager = $this->getMock('BaconUser\Password\HandlerManager');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Password\HandlerManager', $handlerManager);
        $locator->setService('BaconUser\Config', array('password' => array('handler_aggregate' => array())));

        $factory = new HandlerAggregateFactory();
        $this->assertInstanceOf('BaconUser\Password\HandlerAggregate', $factory->createService($locator));
    }
}
