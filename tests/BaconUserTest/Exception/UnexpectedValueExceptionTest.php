<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Exception;

use BaconUser\Exception\UnexpectedValueException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Exception\UnexpectedValueException
 */
class UnexpectedValueExceptionTest extends TestCase
{
    public function testInvalidUserEntity()
    {
        $exception = UnexpectedValueException::invalidUserEntity(array());
        $this->assertInstanceOf('BaconUser\Exception\UnexpectedValueException', $exception);
        $this->assertEquals('array does not implement BaconUser\Entity\UserInterface', $exception->getMessage());
    }
}
