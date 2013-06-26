<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Entity\User;
use BaconUser\Options\UserOptions;
use BaconUser\Service\RegistrationService;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Service\RegistrationService
 */
class RegistrationServiceTest extends TestCase
{
    public function testStateIsSetWhenEnabled()
    {
        $user = new User();

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => true, 'default_user_state' => 2));
        $service = new RegistrationService($objectManager, $options);
        $result  = $service->register($user);
        $this->assertSame($user, $result);
        $this->assertEquals(2, $result->getState());
    }

    public function testStateIsNotSetWhenDisabled()
    {
        $user = new User();

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => false, 'default_user_state' => 2));
        $service = new RegistrationService($objectManager, $options);
        $result  = $service->register($user);
        $this->assertSame($user, $result);
        $this->assertNull($result->getState());
    }

    public function testCanRetrieveUserPrototype()
    {
        $user = new User();

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => false, 'default_user_state' => 2));
        $service = new RegistrationService($objectManager, $options);

        $service->setUserPrototype($user);

        $this->assertSame($user, $service->getUserPrototype());
    }

    public function testDefaultUserPrototype()
    {
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => false, 'default_user_state' => 2));
        $service = new RegistrationService($objectManager, $options);

        $this->assertInstanceOf('BaconUser\Entity\UserInterface', $service->getUserPrototype());
    }
}
