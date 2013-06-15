<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Options;

use BaconUser\Options\PasswordResetOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Options\PasswordResetOptions
 */
class PasswordResetOptionsTest extends TestCase
{
    public function testSetValues()
    {
        $options = new PasswordResetOptions(array(
            'token_validity_interval' => '+2 days'
        ));

        $tokenValidity = $options->getTokenValidityInterval();

        $this->assertInstanceOf('DateInterval', $tokenValidity, 'token_validity_interval must be a DateInterval object');
        $this->assertEquals(2, $tokenValidity->d);
    }
}
