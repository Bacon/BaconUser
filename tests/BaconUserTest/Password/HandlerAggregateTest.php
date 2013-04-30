<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password;

use BaconUser\Password\HandlerAggregate;
use PHPUnit_Framework_TestCase as TestCase;

class HandlerAggregateTest extends TestCase
{
    public function testSupports()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->setHashingMethods(array());
        $this->assertFalse($aggregate->supports('foobar'));

        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));

        $aggregate->getHandlerManager()->setService('foobar', $handler);
        $aggregate->setHashingMethods(array('foobar'));
        $this->assertTrue($aggregate->supports('bazbat'));
    }

    public function testHash()
    {
        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('hash')
                ->with($this->equalTo('foobar'))
                ->will($this->returnValue('bazbat'));

        $aggregate = new HandlerAggregate();
        $aggregate->getHandlerManager()->setService('foobar', $handler);
        $aggregate->setDefaultHashingMethod('foobar');

        $this->assertEquals('bazbat', $aggregate->hash('foobar'));
    }

    public function testCompare()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->setHashingMethods(array());
        $this->assertFalse($aggregate->compare('foobar', 'bazbat'));

        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));
        $handler->expects($this->once())
                ->method('compare')
                ->with($this->equalTo('foobar'), $this->equalTo('bazbat'))
                ->will($this->returnValue(true));

        $aggregate->getHandlerManager()->setService('foobar', $handler);
        $aggregate->setHashingMethods(array('foobar'));

        $this->assertTrue($aggregate->compare('foobar', 'bazbat'));
    }

    public function testShouldRehash()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->setHashingMethods(array());
        $aggregate->setDefaultHashingMethod('foobar');
        $this->assertTrue($aggregate->shouldRehash('bazbat'));

        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));
        $handler->expects($this->once())
                ->method('shouldRehash')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(false));

        $aggregate->getHandlerManager()->setService('foobar', $handler);
        $aggregate->setHashingMethods(array('foobar'));

        $this->assertFalse($aggregate->shouldRehash('bazbat'));
    }
}
