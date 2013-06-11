<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\InputFilter\Factory;

use BaconUser\InputFilter\Factory\RegistrationFilterFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\InputFilter\Factory\RegistrationFilterFactory
 */
class RegistrationFilterFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $userRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $options        = $this->getMock('BaconUser\Options\UserOptionsInterface');

        $parentLocator = new ServiceManager();
        $parentLocator->setService('BaconUser\Repository\UserRepository', $userRepository);
        $parentLocator->setService('BaconUser\Options\UserOptions', $options);

        $inputFilterManager = new InputFilterPluginManager();
        $inputFilterManager->setServiceLocator($parentLocator);

        $factory = new RegistrationFilterFactory();
        $factory->createService($inputFilterManager);
        // Expect no exceptions or errors.
    }
}
