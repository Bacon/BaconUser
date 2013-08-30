<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form\Factory;

use BaconUser\Form\Factory\UserFieldsetFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * @covers BaconUser\Form\Factory\UserFieldsetFactory
 */
class UserFieldsetFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $options     = $this->getMock('BaconUser\Options\UserOptionsInterface');

        $parentLocator = new ServiceManager();
        $parentLocator->setService('BaconUser\Options\UserOptions', $options);

        $hydratorManager = new HydratorPluginManager();
        $hydratorManager->setServiceLocator($parentLocator);
        $hydratorManager->setService('BaconUser\Hydrator\UserHydrator', $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface'));

        $parentLocator->setService('HydratorManager', $hydratorManager);

        $formManager = new FormElementManager();
        $formManager->setServiceLocator($parentLocator);

        $factory = new UserFieldsetFactory();
        $factory->createService($formManager);
        // Expect no exceptions or errors.
    }
}
