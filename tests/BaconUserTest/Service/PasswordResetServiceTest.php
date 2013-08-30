<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Options\PasswordResetOptions;
use BaconUser\Repository\PasswordResetRepositoryInterface;
use BaconUser\Repository\UserRepositoryInterface;
use BaconUser\Service\PasswordResetEvent;
use BaconUser\Service\PasswordResetService;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Service\PasswordResetService
 */
class PasswordResetServiceTest extends TestCase
{
    /**
     * @var PasswordResetService
     */
    protected $service;

    /**
     * @var UserRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $userRepository;

    /**
     * @var PasswordResetRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $passwordRepository;

    public function setUp()
    {
        $objectManager            = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->userRepository     = $this->getMock('BaconUser\Repository\UserRepositoryInterface');
        $this->passwordRepository = $this->getMock('BaconUser\Repository\PasswordResetRepositoryInterface');

        $this->service = new PasswordResetService(
            $objectManager,
            $this->userRepository,
            $this->passwordRepository,
            new PasswordResetOptions(array('token_validity_interval' => '+24 hours'))
        );
    }

    public function testSkipsOnMissingUser()
    {
        $this
            ->userRepository
            ->expects($this->atLeastOnce())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue(null));

        $this->assertNull($this->service->createResetPasswordRequest('test@example.com'));
    }

    public function testCanCreatePasswordResetRequest()
    {
        $user = $this->getMock('BaconUser\Entity\UserInterface');

        $this
            ->userRepository
            ->expects($this->any())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue($user));
        $this
            ->passwordRepository
            ->expects($this->once())
            ->method('findOneByUser')
            ->with($user)
            ->will($this->returnValue(null));

        $passwordRequest = $this->service->createResetPasswordRequest('test@example.com');

        $this->assertInstanceOf('BaconUser\Entity\PasswordResetRequest', $passwordRequest);
        $this->assertEquals(24, strlen($passwordRequest->getToken()));
        $this->assertEquals($user, $passwordRequest->getUser());
    }

    public function testReuseSameRequestIfItAlreadyExists()
    {
        $user                 = $this->getMock('BaconUser\Entity\UserInterface');
        $passwordResetRequest = $this
            ->getMockBuilder('BaconUser\Entity\PasswordResetRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this
            ->userRepository
            ->expects($this->any())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue($user));
        $passwordResetRequest
            ->expects($this->any())
            ->method('isExpired')
            ->will($this->returnValue(true));
        $passwordResetRequest
            ->expects($this->once())
            ->method('setToken')
            ->with(
                $this->callback(
                    function ($token) {
                        return 24 === strlen($token);
                    }
                )
            );
        $passwordResetRequest
            ->expects($this->once())
            ->method('setExpirationDate')
            ->with($this->isInstanceOf('DateTime'));
        $this
            ->passwordRepository
            ->expects($this->any())
            ->method('findOneByUser')
            ->with($user)
            ->will($this->returnValue($passwordResetRequest));

        $this->assertSame($passwordResetRequest, $this->service->createResetPasswordRequest('test@example.com'));
    }

    public function testEventIsTriggeredWhenPasswordResetRequestIsCreated()
    {
        $callback     = $this->getMock('stdLib', array('__invoke'));
        $eventManager = $this->service->getEventManager();
        $user         = $this->getMock('BaconUser\Entity\UserInterface');

        $callback->expects($this->once())->method('__invoke');
        $this
            ->userRepository
            ->expects($this->any())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue($user));
        $this
            ->passwordRepository
            ->expects($this->any())
            ->method('findOneByUser')
            ->with($user)
            ->will($this->returnValue(null));

        $eventManager->attach(PasswordResetEvent::EVENT_CREATED, $callback);

        $this->service->createResetPasswordRequest('test@example.com');
    }

    public function testNotFoundResetRequestDoesNotValidateToken()
    {
        $this->assertFalse($this->service->isTokenValid('test@example.com', 'my-token'));
    }

    public function testCannotValidateTokenWithNoUser()
    {
        $this
            ->userRepository
            ->expects($this->any())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue(null));

        $this
            ->passwordRepository
            ->expects($this->never())
            ->method('findOneByUser');

        $this->assertFalse($this->service->isTokenValid('test@example.com', 'valid-token'));
    }

    public function testCanValidateToken()
    {
        $user            = $this->getMock('BaconUser\Entity\UserInterface');
        $existingRequest = $this
            ->getMockBuilder('BaconUser\Entity\PasswordResetRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $existingRequest
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('valid-token'));
        $existingRequest
            ->expects($this->any())
            ->method('isExpired')
            ->will($this->returnValue(false));
        $this
            ->userRepository
            ->expects($this->any())
            ->method('findOneByEmail')
            ->with('test@example.com')
            ->will($this->returnValue($user));
        $this
            ->passwordRepository
            ->expects($this->any())
            ->method('findOneByUser')
            ->with($user)
            ->will($this->returnValue($existingRequest));

        $this->assertTrue($this->service->isTokenValid('test@example.com', 'valid-token'));
        $this->assertFalse($this->service->isTokenValid('test@example.com', 'invalid-token'));
    }

    public function testIdentifiersAreAddedToEventManager()
    {
        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');

        $eventManager
            ->expects($this->once())
            ->method('setIdentifiers')
            ->with($this->contains('BaconUser\Service\PasswordResetService'));

        $this->service->setEventManager($eventManager);

        $this->assertSame($eventManager, $this->service->getEventManager());
    }
}
