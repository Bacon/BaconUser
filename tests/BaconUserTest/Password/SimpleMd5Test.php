<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password;

use BaconUser\Password\SimpleMd5;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Password\SimpleMd5
 */
class SimpleMd5Test extends TestCase
{
    public function testSupports()
    {
        $handler = new SimpleMd5();
        $this->assertTrue($handler->supports('$simple-md5$3858f62230ac3c915f300c664312c63f'));
        $this->assertFalse($handler->supports('3858f62230ac3c915f300c664312c63f'));
    }

    public function testHash()
    {
        $handler = new SimpleMd5();
        $this->assertEquals('$simple-md5$3858f62230ac3c915f300c664312c63f', $handler->hash('foobar'));
    }

    public function testCompare()
    {
        $handler = new SimpleMd5();
        $this->assertTrue($handler->compare('foobar', '$simple-md5$3858f62230ac3c915f300c664312c63f'));
        $this->assertFalse($handler->compare('foobaz', '$simple-md5$3858f62230ac3c915f300c664312c63f'));
    }

    public function testShouldRehash()
    {
        $handler = new SimpleMd5();
        $this->assertFalse($handler->shouldRehash(null));
    }
}
