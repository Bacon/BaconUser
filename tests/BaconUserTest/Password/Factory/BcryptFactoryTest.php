<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password\Factory;

use BaconUser\Password\Factory\BcryptFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Password\Factory\BcryptFactory
 */
class BcryptFactoryTest extends TestCase
{
    public function testFactoryFromPluginManager()
    {
        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', array());

        $pluginManager = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $pluginManager->expects($this->once())
                      ->method('getServiceLocator')
                      ->will($this->returnValue($locator));

        $factory = new BcryptFactory();
        $this->assertInstanceOf('BaconUser\Password\Bcrypt', $factory->createService($pluginManager));
    }

    public function testFactoryWithCostSet()
    {
        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', array('password' => array('bcrypt' => array('cost' => 4))));

        $pluginManager = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $pluginManager->expects($this->once())
                      ->method('getServiceLocator')
                      ->will($this->returnValue($locator));

        $factory = new BcryptFactory();
        $this->assertInstanceOf('BaconUser\Password\Bcrypt', $factory->createService($pluginManager));
    }
}
