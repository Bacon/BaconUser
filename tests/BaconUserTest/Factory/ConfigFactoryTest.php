<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Factory;

use BaconUser\Factory\ConfigFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Factory\ConfigFactory
 */
class ConfigFactoryTest extends TestCase
{
    public function testFactoryReturnsBaconUserConfig()
    {
        $config = array('bacon_user' => array('foo' => 'bar'));

        $locator = new ServiceManager();
        $locator->setService('Config', $config);

        $factory = new ConfigFactory();
        $this->assertEquals(array('foo' => 'bar'), $factory->createService($locator));
    }

    public function testFactoryReturnsEmptyArrayWithoutConfig()
    {
        $config = array();

        $locator = new ServiceManager();
        $locator->setService('Config', $config);

        $factory = new ConfigFactory();
        $this->assertEquals(array(), $factory->createService($locator));
    }
}
