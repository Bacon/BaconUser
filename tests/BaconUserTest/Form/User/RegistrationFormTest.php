<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form\User;

use BaconUser\Form\User\RegistrationForm;
use BaconUser\Form\UserFieldset;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Form\FormElementManager;

/**
 * @covers BaconUser\Form\User\RegistrationForm
 */
class RegistrationFormTest extends TestCase
{
    /**
     * @var RegistrationForm
     */
    protected $registrationForm;

    public function setUp()
    {
        $formElementManager = new FormElementManager();
        $formElementManager->setFactory('BaconUser\Form\UserFieldset', function($serviceLocator) {
            return new UserFieldset($this->getMock('Zend\Stdlib\Hydrator\HydratorInterface'), new UserOptions());
        });

        $this->registrationForm = $formElementManager->get('BaconUser\Form\User\RegistrationForm');
    }

    public function testFormHasDefaultName()
    {
        $this->assertEquals('registration-form', $this->registrationForm->getName());
    }

    public function testAssertUserFieldsetIsConfiguredAsBaseFieldset()
    {
        $this->assertTrue($this->registrationForm->get('user')->useAsBaseFieldset(), 'User fieldset is not configured as base fieldset');
    }

    public function testContextSpecificElements()
    {
        $this->assertTrue($this->registrationForm->has('csrf'), 'CSRF field missing');
        $this->assertTrue($this->registrationForm->has('submit'), 'Submit field missing');
        $this->assertTrue($this->registrationForm->get('user')->has('passwordVerification'), 'Password verification field missing');
    }
}
