<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service\Factory;

use BaconUser\Service\Factory\PasswordResetServiceFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Service\Factory\PasswordResetServiceFactory
 * @covers BaconUser\Service\PasswordResetService
 */
class PasswordResetServiceFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $serviceLocator   = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $services         = array(
            'BaconUser\ObjectManager' => $this->getMock('Doctrine\Common\Persistence\ObjectManager'),
            'BaconUser\Repository\UserRepository'
                => $this->getMock('BaconUser\Repository\UserRepositoryInterface'),
            'BaconUser\Repository\PasswordResetRepository'
                => $this->getMock('BaconUser\Repository\PasswordResetRepositoryInterface'),
            'BaconUser\Options\PasswordResetOptions'
                => $this->getMock('BaconUser\Options\PasswordResetOptionsInterface'),
        );

        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($serviceName) use ($services) {
                        return $services[$serviceName];
                    }
                )
            );

        $factory = new PasswordResetServiceFactory();

        $this->assertInstanceOf('BaconUser\Service\PasswordResetService', $factory->createService($serviceLocator));
    }
}
