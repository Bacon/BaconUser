<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password;

use BaconUser\Password\HandlerManager;
use PHPUnit_Framework_TestCase as TestCase;
use stdClass;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Password\HandlerManager
 */
class HandlerManagerTest extends TestCase
{
    public function testCreateSimpleMd5()
    {
        $manager = new HandlerManager();
        $this->assertInstanceOf('BaconUser\Password\SimpleMd5', $manager->get('SimpleMd5'));
    }

    public function testCreateSimpleSha1()
    {
        $manager = new HandlerManager();
        $this->assertInstanceOf('BaconUser\Password\SimpleSha1', $manager->get('SimpleSha1'));
    }

    public function testCreateBcrypt()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('BaconUser\Config', array());
        $manager = new HandlerManager();
        $manager->setServiceLocator($serviceManager);
        $this->assertInstanceOf('BaconUser\Password\Bcrypt', $manager->get('Bcrypt'));
    }

    public function testCreateInvalidHandler()
    {
        $this->setExpectedException(
            'BaconUser\Exception\RuntimeException',
            'Plugin of type stdClass is invalid; must implement BaconUser\Password\HandlerInterface'
        );

        $manager = new HandlerManager();
        $manager->setService('invalid', new stdClass());
    }
}
