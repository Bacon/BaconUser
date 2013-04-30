<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Password\SimpleSha1;
use PHPUnit_Framework_TestCase as TestCase;

class SimpleSha1Test extends TestCase
{
    public function testSupports()
    {
        $handler = new SimpleSha1();
        $this->assertTrue($handler->supports('$simple-sha1$8843d7f92416211de9ebb963ff4ce28125932878'));
        $this->assertFalse($handler->supports('8843d7f92416211de9ebb963ff4ce28125932878'));
    }

    public function testHash()
    {
        $handler = new SimpleSha1();
        $this->assertEquals('$simple-sha1$8843d7f92416211de9ebb963ff4ce28125932878', $handler->hash('foobar'));
    }

    public function testCompare()
    {
        $handler = new SimpleSha1();
        $this->assertTrue($handler->compare('foobar', '$simple-sha1$8843d7f92416211de9ebb963ff4ce28125932878'));
        $this->assertFalse($handler->compare('foobaz', '$simple-sha1$8843d7f92416211de9ebb963ff4ce28125932878'));
    }

    public function testShouldRehash()
    {
        $handler = new SimpleSha1();
        $this->assertFalse($handler->shouldRehash(null));
    }
}
