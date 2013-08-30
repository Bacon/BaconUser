<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Entity;

use BaconUser\Entity\User;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;

/**
 * @covers BaconUser\Entity\User
 */
class UserTest extends TestCase
{
    public static function setterGetterProvider()
    {
        return array(
            array(
                'Email',
                'foobar@example.com',
            ),
            array(
                'PasswordHash',
                'bazbat',
            ),
            array(
                'Username',
                'foobar',
            ),
            array(
                'State',
                '1',
            ),
        );
    }

    public function testId()
    {
        $user = new User();
        $this->assertNull($user->getId());

        $reflector = new ReflectionClass($user);
        $property  = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($user, 1);

        $this->assertEquals(1, $user->getId());
    }

    /**
     * @dataProvider setterGetterProvider
     * @param        string $name
     * @param        mixed  $value
     */
    public function testSetterGetter($name, $value)
    {
        $user = new User();
        $this->assertNull($user->{'get' . $name}());
        $user->{'set' . $name}($value);
        $this->assertEquals($value, $user->{'get' . $name}());
    }
}
