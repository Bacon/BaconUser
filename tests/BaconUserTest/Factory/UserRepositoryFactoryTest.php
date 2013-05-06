<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Factory;

use BaconUser\Factory\UserRepositoryFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Factory\UserRepositoryFactory
 */
class UserRepositoryFactoryTest extends TestCase
{
    public function testFactoryReturnsRepositoryFromObjectManager()
    {
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->expects($this->once())
                      ->method('getRepository')
                      ->with($this->equalTo('BaconUser\Entity\User'))
                      ->will($this->returnValue('foo'));

        $locator = new ServiceManager();
        $locator->setService('BaconUser\ObjectManager', $objectManager);

        $factory = new UserRepositoryFactory();
        $this->assertEquals('foo', $factory->createService($locator));
    }
}
