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
use Zend\ServiceManager\ServiceManager;

class HandlerManagerTest extends TestCase
{
    public function testCreateSimpleMd5()
    {
        $manager = new HandlerManager();
        $this->assertInstanceOf('BaconUser\Password\SimpleMd5', $manager->get('simple_md5'));
    }

    public function testCreateSimpleSha1()
    {
        $manager = new HandlerManager();
        $this->assertInstanceOf('BaconUser\Password\SimpleSha1', $manager->get('simple_sha1'));
    }

    public function testCreateBcrypt()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', array());
        $manager = new HandlerManager();
        $manager->setServiceLocator($serviceManager);
        $this->assertInstanceOf('BaconUser\Password\Bcrypt', $manager->get('bcrypt'));
    }
}
