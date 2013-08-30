<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Entity;

use BaconUser\Entity\PasswordResetRequest;
use DateInterval;
use DateTime;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;

/**
 * @covers BaconUser\Entity\PasswordResetRequest
 */
class PasswordResetRequestTest extends TestCase
{
    public function setterGetterProvider()
    {
        return array(
            array(
                'Token',
                'azertylol',
            ),
            array(
                'ExpirationDate',
                new DateTime(),
            ),
        );
    }

    public function testGetUser()
    {
        $user = $this->getMock('BaconUser\Entity\UserInterface');

        $passwordResetRequest = new PasswordResetRequest($user);

        $this->assertSame($user, $passwordResetRequest->getUser());
    }

    public function testId()
    {
        $passwordResetRequest = new PasswordResetRequest($this->getMock('BaconUser\Entity\UserInterface'));
        $this->assertNull($passwordResetRequest->getId());

        $reflector = new ReflectionClass($passwordResetRequest);
        $property  = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($passwordResetRequest, 1);

        $this->assertEquals(1, $passwordResetRequest->getId());
    }

    /**
     * @dataProvider setterGetterProvider
     * @param         string $name
     * @param         mixed  $value
     */
    public function testSetterGetter($name, $value)
    {
        $passwordResetRequest = new PasswordResetRequest($this->getMock('BaconUser\Entity\UserInterface'));
        $this->assertNull($passwordResetRequest->{'get' . $name}());
        $passwordResetRequest->{'set' . $name}($value);
        $this->assertEquals($value, $passwordResetRequest->{'get' . $name}());
    }

    public function testTokenExpirationLogic()
    {
        $passwordResetRequest = new PasswordResetRequest($this->getMock('BaconUser\Entity\UserInterface'));

        $expirationInFuture = new DateTime();
        $expirationInFuture->add(new DateInterval('P1D'));
        $passwordResetRequest->setExpirationDate($expirationInFuture);
        $this->assertFalse($passwordResetRequest->isExpired());

        $expirationInPast = new DateTime();
        $expirationInPast->sub(new DateInterval('P1D'));
        $passwordResetRequest->setExpirationDate($expirationInPast);
        $this->assertTrue($passwordResetRequest->isExpired());
    }
}
