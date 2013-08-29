<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Service\RegistrationEvent;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Service\RegistrationEvent
 */
class RegistrationEventTest extends TestCase
{
    public function testCanCreateEvent()
    {
        $user = $this->getMock('BaconUser\Entity\UserInterface');
        $event = new RegistrationEvent($user);

        $this->assertSame($user, $event->getUser());
        $this->assertEquals(RegistrationEvent::EVENT_USER_REGISTERED, $event->getName());
    }
}
