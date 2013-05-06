<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password\Factory;

use BaconUser\Password\Factory\HandlerManagerFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Password\Factory\HandlerManagerFactory
 */
class HandlerManagerFactoryTest extends TestCase
{
    public function testFactoryWithoutConfig()
    {
        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', array());

        $factory = new HandlerManagerFactory();
        $this->assertInstanceOf('BaconUser\Password\HandlerManager', $factory->createService($locator));
    }

    public function testFactoryWithConfig()
    {
        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', array('password' => array('handler_manager' => array())));

        $factory = new HandlerManagerFactory();
        $this->assertInstanceOf('BaconUser\Password\HandlerManager', $factory->createService($locator));
    }
}
