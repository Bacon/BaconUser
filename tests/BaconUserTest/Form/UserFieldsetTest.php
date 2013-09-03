<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form;

use BaconUser\Form\UserFieldset;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Form\UserFieldset
 */
class UserFieldsetTest extends TestCase
{
    public function testFieldsetWithAllFieldsEnabled()
    {
        $form = new UserFieldset(
            $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface'),
            new UserOptions(array(
                'enable_username' => true,
            ))
        );

        $this->assertTrue($form->has('username'), 'Username field missing');
        $this->assertTrue($form->has('email'), 'Email field missing');
        $this->assertTrue($form->has('password'), 'Password field missing');
    }

    public function testFormWithUsernameDisabled()
    {
        $form = new UserFieldset(
            $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface'),
            new UserOptions(array(
                'enable_username' => false,
            ))
        );

        $this->assertFalse($form->has('username'), 'Username field exists');
    }
}
