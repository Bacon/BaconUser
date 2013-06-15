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
 */
class PasswordResetServiceFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $repository       = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $options          = $this->getMock('BaconUser\Options\PasswordResetOptionsInterface');

        $repository->expects($this->once())
                   ->method('getClassName')
                   ->will($this->returnValue('BaconUser\Entity\PasswordResetRequest'));

        $locator = new ServiceManager();
        $locator->setService('BaconUser\ObjectManager', $objectManager);
        $locator->setService('BaconUser\Repository\PasswordResetRepository', $repository);
        $locator->setService('BaconUser\Options\PasswordResetOptions', $options);

        $factory = new PasswordResetServiceFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }

    public function testThrowExceptionIfInvalidRepositoryIsGiven()
    {
        $this->setExpectedException('BaconUser\Exception\InvalidArgumentException');

        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $repository       = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $options          = $this->getMock('BaconUser\Options\PasswordResetOptionsInterface');

        $repository->expects($this->once())
                   ->method('getClassName')
                   ->will($this->returnValue('ABadValue'));

        $locator = new ServiceManager();
        $locator->setService('BaconUser\ObjectManager', $objectManager);
        $locator->setService('BaconUser\Repository\PasswordResetRepository', $repository);
        $locator->setService('BaconUser\Options\PasswordResetOptions', $options);

        $factory = new PasswordResetServiceFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }
}
