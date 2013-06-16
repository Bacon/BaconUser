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
use BaconUser\Options\PasswordResetOptions;
use BaconUser\Service\PasswordResetEvent;
use BaconUser\Service\PasswordResetService;
use DateInterval;
use DateTime;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\EventManager;

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
     * @var ObjectRepository
     */
    protected $repository;

    public function setUp()
    {
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->repository->expects($this->once())
                         ->method('getClassName')
                         ->will($this->returnValue('BaconUser\Entity\PasswordResetRequest'));

        $this->service = new PasswordResetService($objectManager, $this->repository, new PasswordResetOptions(array(
            'token_validity_interval' => '+24 hours'
        )));
    }

    public function testCanCreatePasswordResetRequest()
    {
        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array('email' => 'test@example.com'))
                         ->will($this->returnValue(null));

        $passwordRequest = $this->service->createResetPasswordRequest('test@example.com');

        $this->assertEquals(24, strlen($passwordRequest->getToken()));
        $this->assertEquals('test@example.com', $passwordRequest->getEmail());
    }

    public function testReuseSameRequestIfItAlreadyExists()
    {
        $existingPasswordReset = new PasswordResetRequest();
        $existingPasswordReset->setEmail('test@example.com');

        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array('email' => 'test@example.com'))
                         ->will($this->returnValue($existingPasswordReset));

        $passwordRequest = $this->service->createResetPasswordRequest('test@example.com');

        $this->assertEquals(24, strlen($passwordRequest->getToken()));
        $this->assertEquals('test@example.com', $passwordRequest->getEmail());
        $this->assertSame($existingPasswordReset, $passwordRequest);
    }

    public function testEventIsTriggeredWhenPasswordResetRequestIsCreated()
    {
        $eventIsCalled = false;

        $eventManager = $this->service->getEventManager();
        $eventManager->attach(PasswordResetEvent::EVENT_CREATED, function() use (&$eventIsCalled) {
            $eventIsCalled = true;
        });

        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array('email' => 'test@example.com'))
                         ->will($this->returnValue(null));

        $this->service->createResetPasswordRequest('test@example.com');

        $this->assertTrue($eventIsCalled);
    }

    public function testNotFoundResetRequestDoesNotValidateToken()
    {
        $this->repository->expects($this->once())
                         ->method('findOneBy')
                         ->with(array('email' => 'test@example.com'))
                         ->will($this->returnValue(null));

        $this->assertFalse($this->service->isTokenValid('test@example.com', 'my-token'));
    }

    public function testCanValidateToken()
    {
        $existingPasswordReset = new PasswordResetRequest();

        // Set an expiration date in the future so that token is not validated
        $expirationDateInFuture = new DateTime();
        $expirationDateInFuture->add(new DateInterval('P1D'));

        $existingPasswordReset->setToken('valid-token')
                              ->setExpirationDate($expirationDateInFuture);

        $this->repository->expects($this->exactly(2))
                         ->method('findOneBy')
                         ->with(array('email' => 'test@example.com'))
                         ->will($this->returnValue($existingPasswordReset));

        $this->assertTrue($this->service->isTokenValid('test@example.com', 'valid-token'));
        $this->assertFalse($this->service->isTokenValid('test@example.com', 'invalid-token'));
    }

    public function testIdentifiersAreAddedToEventManager()
    {
        $eventManager = new EventManager();
        $this->service->setEventManager($eventManager);

        $this->assertContains('BaconUser\Service\PasswordResetService', $eventManager->getIdentifiers());
    }
}
