<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service\Factory;

use BaconUser\Service\Factory\RegistrationServiceFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Service\Factory\RegistrationServiceFactory
 */
class RegistrationServiceFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $registrationForm = $this->getMock('Zend\Form\FormInterface');
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $options          = $this->getMock('BaconUser\Options\UserOptionsInterface');
        $userPrototype    = $this->getMock('BaconUser\Entity\UserInterface');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Form\User\RegistrationForm', $registrationForm);
        $locator->setService('BaconUser\ObjectManager', $objectManager);
        $locator->setService('BaconUser\Options\UserOptions', $options);
        $locator->setService('BaconUser\Entity\UserPrototype', $userPrototype);

        $factory = new RegistrationServiceFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }
}
