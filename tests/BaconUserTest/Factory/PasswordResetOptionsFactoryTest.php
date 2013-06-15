<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Factory;

use BaconUser\Factory\PasswordResetOptionsFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Factory\PasswordResetOptionsFactory
 */
class PasswordResetOptionsFactoryTest extends TestCase
{
    public function testFactoryReturnsInjectedOptions()
    {
        $config = array('password_reset' => array('token_validity_interval' => '+10 hours'));

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Config', $config);

        $factory = new PasswordResetOptionsFactory();
        $this->assertInstanceOf('DateInterval', $factory->createService($locator)->getTokenValidityInterval());
    }
}
