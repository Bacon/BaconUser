<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form;

use BaconUser\Form\RegistrationFilter;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Form\RegistrationFilter
 */
class RegistrationFilterTest extends TestCase
{
    public static function formDataProvider()
    {
        return array(
            'completely-valid-input' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
            ),
            'space-padded-valid-input' => array(
                array(
                    'username'              => ' foobar ',
                    'email'                 => ' foobar@example.com ',
                    // @todo Bug with identical validator (compares filtered against raw value)
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => ' Example ',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
            ),
            'duplicate-email' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
                null,
                true,
                true,
                false,
                true
            ),
            'duplicate-username' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
                null,
                true,
                true,
                true,
                false
            ),
            'non-identical-passwords' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'foobar',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
            ),
            'invalid-with-enabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
            ),
            'valid-with-disabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => 'Example',
                ),
                false
            ),
            'valid-with-enabled-display-name' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                    'display_name'          => null,
                ),
            ),
            'valid-with-disabled-display-name' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'password_verification' => 'bazbat',
                ),
                true,
                false
            ),
        );
    }

    /**
     * @dataProvider formDataProvider
     * @param        array      $input
     * @param        array|null $output
     * @param        bool       $enableUsername
     * @param        bool       $enableDisplayName
     * @param        bool       $emailIsUnique
     * @param        bool       $usernameIsUnique
     * @return       void
     */
    public function testInputFilter(
        array $input,
        array $output = null,
        $enableUsername = true,
        $enableDisplayName = true,
        $emailIsUnique = true,
        $usernameIsUnique = true
    ) {
        $filter = new RegistrationFilter(
            $this->getMockValidator($emailIsUnique),
            $this->getMockValidator($usernameIsUnique),
            new UserOptions(array(
                'enable_username'     => $enableUsername,
                'enable_display_name' => $enableDisplayName,
            ))
        );

        $filter->setData($input);

        if ($output === null) {
            $this->assertFalse($filter->isValid(), 'Input must not be valid');
        } else {
            $this->assertTrue($filter->isValid(), 'Input must be valid');
            $this->assertEquals($output, $filter->getValues());
        }
    }

    /**
     * @param  bool $validates
     * @return \Zend\Validator\ValidatorInterface
     */
    protected function getMockValidator($validates)
    {
        $validator = $this->getMock('Zend\Validator\ValidatorInterface');
        $validator->expects($this->any())
                  ->method('isValid')
                  ->will($this->returnValue($validates));

        if (!$validates) {
            $validator->expects($this->any())
                      ->method('getMessages')
                      ->will($this->returnValue(array()));
        }

        return $validator;
    }
}
