<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Factory;

use BaconUser\Factory\UserOptionsFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Factory\UserOptionsFactory
 */
class UserOptionsFactoryTest extends TestCase
{
    public function testFactoryReturnsInjectedOptions()
    {
        $config = array('user' => array('enable_username' => false));

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', $config);

        $factory = new UserOptionsFactory();
        $this->assertFalse($factory->createService($locator)->getEnableUsername());

    }

    public function testFactoryReturnsDefaultOptionsWithoutConfig()
    {
        $config = array();

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', $config);

        $factory = new UserOptionsFactory();
        $this->assertTrue($factory->createService($locator)->getEnableUsername());
    }
}
