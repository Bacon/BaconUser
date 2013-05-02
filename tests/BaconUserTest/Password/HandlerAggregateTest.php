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

/**
 * @covers BaconUser\Password\HandlerAggregate
 */
class HandlerAggregateTest extends TestCase
{
    public function testSupports()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setHashingMethods(array());

        $this->assertFalse(
            $aggregate->supports('foobar'),
            'Unknown hash must return false'
        );

        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));

        $aggregate->getHandlerManager()->setService('foobar', $handler);
        $aggregate->getOptions()->setHashingMethods(array('foobar'));

        $this->assertTrue(
            $aggregate->supports('bazbat'),
            'Known hash must return true'
        );
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
        $aggregate->getOptions()->setDefaultHashingMethod('foobar');

        $this->assertEquals('bazbat', $aggregate->hash('foobar'));
    }

    public function testCompare()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setHashingMethods(array());

        $this->assertFalse(
            $aggregate->compare('foobar', 'bazbat'),
            'Unknown hash must be considered not matching'
        );

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
        $aggregate->getOptions()->setHashingMethods(array('foobar'));

        $this->assertTrue(
            $aggregate->compare('foobar', 'bazbat'),
            'Known hash matched by handler must be considered matching'
        );
    }

    public function testShouldRehashWithUnknownHash()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setDefaultHashingMethod('foobar')
                                ->setHashingMethods(array());

        $this->assertTrue(
            $aggregate->shouldRehash('bazbat'),
            'Unknwon hash must trigger rehash'
        );
    }

    public function testShouldRehashWithHandlerReportingRehash()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setDefaultHashingMethod('foobar')
                                ->setHashingMethods(array('foobar'));

        $handler = $this->getMock('BaconUser\Password\HandlerInterface');
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));
        $handler->expects($this->once())
                ->method('shouldRehash')
                ->with($this->equalTo('bazbat'))
                ->will($this->returnValue(true));

        $aggregate->getHandlerManager()->setService('foobar', $handler);

        $this->assertTrue(
            $aggregate->shouldRehash('bazbat'),
            'Known hash reported to rehash by handler must trigger rehash'
        );
    }

    public function testShouldRehashWithHandlerReportingNoRehash()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setDefaultHashingMethod('foobar')
                                ->setHashingMethods(array('foobar'));

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

        $this->assertFalse(
            $aggregate->shouldRehash('bazbat'),
            'Known hash reported to not rehash must not trigger rehash'
        );
    }

    public function testShouldRehashWithObsoleteHash()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setDefaultHashingMethod('foobar')
                                ->setHashingMethods(array('foobar', 'bazbat'));

        $handlerA = $this->getMock('BaconUser\Password\HandlerInterface');
        $handlerA->expects($this->once())
                 ->method('supports')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(false));
        $handlerB = $this->getMock('BaconUser\Password\HandlerInterface');
        $handlerB->expects($this->once())
                 ->method('supports')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(true));
        $handlerB->expects($this->once())
                 ->method('shouldRehash')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(false));

        $aggregate->getHandlerManager()->setService('foobar', $handlerA);
        $aggregate->getHandlerManager()->setService('bazbat', $handlerB);

        $this->assertTrue(
            $aggregate->shouldRehash('bazbat'),
            'Known hash not matching default hashing method must trigger rehash'
        );
    }

    public function testShouldRehashWithObsoleteHashAndMigrationDisabled()
    {
        $aggregate = new HandlerAggregate();
        $aggregate->getOptions()->setDefaultHashingMethod('foobar')
                                ->setHashingMethods(array('foobar', 'bazbat'))
                                ->setMigrateToDefaultHashingMethod(false);

        $handlerA = $this->getMock('BaconUser\Password\HandlerInterface');
        $handlerA->expects($this->once())
                 ->method('supports')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(false));
        $handlerB = $this->getMock('BaconUser\Password\HandlerInterface');
        $handlerB->expects($this->once())
                 ->method('supports')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(true));
        $handlerB->expects($this->once())
                 ->method('shouldRehash')
                 ->with($this->equalTo('bazbat'))
                 ->will($this->returnValue(false));

        $aggregate->getHandlerManager()->setService('foobar', $handlerA);
        $aggregate->getHandlerManager()->setService('bazbat', $handlerB);

        $this->assertFalse(
            $aggregate->shouldRehash('bazbat'),
            'Known hash not matching default hashing method with migration disabled must not trigger rehash'
        );
    }
}
