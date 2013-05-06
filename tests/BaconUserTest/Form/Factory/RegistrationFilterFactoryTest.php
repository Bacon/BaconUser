<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form\Factory;

use BaconUser\Form\Factory\RegistrationFilterFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Form\Factory\RegistrationFilterFactory
 */
class RegistrationFilterFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $userRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $options        = $this->getMock('BaconUser\Options\UserOptionsInterface');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Repository\UserRepository', $userRepository);
        $locator->setService('BaconUser\Options\UserOptions', $options);

        $factory = new RegistrationFilterFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }
}
