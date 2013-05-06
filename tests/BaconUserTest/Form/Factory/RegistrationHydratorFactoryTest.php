<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form\Factory;

use BaconUser\Form\Factory\RegistrationHydratorFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Form\Factory\RegistrationHydratorFactory
 */
class RegistrationHydratorFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $handler = $this->getMock('BaconUser\Password\HandlerInterface');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Password\HandlerInterface', $handler);

        $factory = new RegistrationHydratorFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }
}
