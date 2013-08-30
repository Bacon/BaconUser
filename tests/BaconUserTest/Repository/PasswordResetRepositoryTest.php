<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Repository;

use BaconUser\Repository\PasswordResetRepository;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Repository\PasswordResetRepository
 */
class PasswordResetRepositoryTest extends TestCase
{
    public function testCanRetrieveObject()
    {
        $user           = $this->getMock('BaconUser\Entity\UserInterface');
        $baseRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $passwordReset  = $this
            ->getMockBuilder('BaconUser\Entity\PasswordResetRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $baseRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(array('user' => $user))
            ->will($this->returnValue($passwordReset));

        $repository = new PasswordResetRepository($baseRepository);

        $this->assertSame($passwordReset, $repository->findOneByUser($user));
    }
}
