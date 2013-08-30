<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Options;

use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Options\UserOptions
 */
class UserOptionsTest extends TestCase
{
    public function testDefaults()
    {
        $options = new UserOptions();
        $this->assertTrue($options->getEnableUsername(), 'enable_username must default to true');
        $this->assertTrue($options->getEnableUserState(), 'enable_user_state must default to true');
        $this->assertEquals(1, $options->getDefaultUserState());
        $this->assertEquals(array(null, 1), $options->getAllowedLoginStates());
    }

    public function testSetValues()
    {
        $options = new UserOptions(array(
            'enable_username'      => false,
            'enable_user_state'    => false,
            'default_user_state'   => 2,
            'allowed_login_states' => array(2)
        ));

        $this->assertFalse($options->getEnableUsername(), 'enable_username must be false');
        $this->assertFalse($options->getEnableUserState(), 'enable_user_state must be false');
        $this->assertEquals(2, $options->getDefaultUserState());
        $this->assertEquals(array(2), $options->getAllowedLoginStates());
    }
}
