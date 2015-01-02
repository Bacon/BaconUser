<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form\Factory;

use BaconUser\Form\Factory\RegistrationFormFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Form\FormElementManager;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

/**
 * @covers BaconUser\Form\Factory\RegistrationFormFactory
 */
class RegistrationFormFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $options     = $this->getMock('BaconUser\Options\UserOptionsInterface');
        $inputFilter = $this->getMock('Zend\InputFilter\InputFilterInterface');

        $parentLocator = new ServiceManager();
        $parentLocator->setService('BaconUser\Options\UserOptions', $options);

        $inputFilterManager = new InputFilterPluginManager();
        $inputFilterManager->setServiceLocator($parentLocator);
        $inputFilterManager->setService('BaconUser\InputFilter\RegistrationFilter', $inputFilter);

        $parentLocator->setService('InputFilterManager', $inputFilterManager);

        $formManager = new FormElementManager();
        $formManager->setServiceLocator($parentLocator);

        $factory = new RegistrationFormFactory();
        $factory->createService($formManager);
        // Expect no exceptions or errors.
    }
}
