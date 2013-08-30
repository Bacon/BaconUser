<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form;

use BaconUser\Form\RegistrationForm;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Form\RegistrationForm
 */
class RegistrationFormTest extends TestCase
{
    public function testFormWithAllFieldsEnabled()
    {
        $form = new RegistrationForm(
            new UserOptions(array(
                'enable_username'     => true,
            ))
        );

        $this->assertTrue($form->has('username'), 'Username field missing');
        $this->assertTrue($form->has('email'), 'Email field missing');
        $this->assertTrue($form->has('password'), 'Password field missing');
        $this->assertTrue($form->has('password_verification'), 'Password verification field missing');
        $this->assertTrue($form->has('submit'), 'Submit field missing');
    }

    public function testFormWithUsernameDisabled()
    {
        $form = new RegistrationForm(
            new UserOptions(array(
                'enable_username'     => false,
            ))
        );

        $this->assertFalse($form->has('username'), 'Username field exists');
    }
}
