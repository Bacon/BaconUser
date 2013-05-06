<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form;

use BaconUser\Form\PasswordHashingStrategy;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Form\PasswordHashingStrategy
 */
class PasswordHashingStrategyTest extends TestCase
{
    public function testHydrateUsesPasswordHandler()
    {
        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('hash')
                ->with($this->equalTo('foobar'))
                ->will($this->returnValue('bazbat'));

        $strategy = new PasswordHashingStrategy($handler);
        $this->assertEquals('bazbat', $strategy->hydrate('foobar'));
    }

    public function testExtractReturnsEmptyString()
    {
        $handler  = $this->getMock('BaconUser\Password\HandlerInterface');
        $strategy = new PasswordHashingStrategy($handler);
        $this->assertEquals('', $strategy->extract('bazbat'));
    }
}
