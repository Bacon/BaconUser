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
use Zend\ServiceManager\ServiceManager;

/**
 * @covers BaconUser\Form\Factory\RegistrationFormFactory
 */
class RegistrationFormFactoryTest extends TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {
        $options     = $this->getMock('BaconUser\Options\UserOptionsInterface');
        $hydrator    = $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface');
        $inputFilter = $this->getMock('Zend\InputFilter\InputFilterInterface');

        $locator = new ServiceManager();
        $locator->setService('BaconUser\Form\RegistrationHydrator', $hydrator);
        $locator->setService('BaconUser\Form\RegistrationFilter', $inputFilter);
        $locator->setService('BaconUser\Options\UserOptions', $options);

        $factory = new RegistrationFormFactory();
        $factory->createService($locator);
        // Expect no exceptions or errors.
    }
}
