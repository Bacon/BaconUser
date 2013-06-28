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
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $serviceLocator   = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $objectManager
            ->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('BaconUser\Entity\User'))
            ->will($this->returnValue($objectRepository));
        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('BaconUser\ObjectManager')
            ->will($this->returnValue($objectManager));

        $factory = new UserRepositoryFactory();
        
        $this->assertInstanceOf('BaconUser\Repository\UserRepository', $factory->createService($serviceLocator));
    }
}
