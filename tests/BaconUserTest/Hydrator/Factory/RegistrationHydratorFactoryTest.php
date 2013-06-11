<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Hydrator\Factory;

use BaconUser\Hydrator\Factory\RegistrationHydratorFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * @covers BaconUser\Form\Factory\RegistrationHydratorFactory
 */
class RegistrationHydratorFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $handler = $this->getMock('BaconUser\Password\HandlerInterface');

        $parentLocator = new ServiceManager();
        $parentLocator->setService('BaconUser\Password\HandlerInterface', $handler);

        $hydratorManager = new HydratorPluginManager();
        $hydratorManager->setServiceLocator($parentLocator);

        $factory = new RegistrationHydratorFactory();
        $factory->createService($hydratorManager);
        // Expect no exceptions or errors.
    }
}
