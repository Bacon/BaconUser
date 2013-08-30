<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Entity\PasswordResetRequest;
use BaconUser\Service\PasswordResetEvent;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Service\PasswordResetEvent
 */
class PasswordResetEventTest extends TestCase
{
    public function testCanCreateEvent()
    {
        $passwordResetRequest = $this
            ->getMockBuilder('BaconUser\Entity\PasswordResetRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $event = new PasswordResetEvent($passwordResetRequest);

        $this->assertSame($passwordResetRequest, $event->getPasswordResetRequest());
        $this->assertEquals(PasswordResetEvent::EVENT_CREATED, $event->getName());
    }
}
