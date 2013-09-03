<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\InputFilter;

use BaconUser\InputFilter\RegistrationFilter;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\InputFilter\RegistrationFilter
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
                    'passwordVerification'  => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
            ),
            'space-padded-valid-input' => array(
                array(
                    'username'              => ' foobar ',
                    'email'                 => ' foobar@example.com ',
                    // @todo Bug with identical validator (compares filtered against raw value)
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
            ),
            'duplicate-email' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'nfoobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
                null,
                true,
                false,
                true
            ),
            'duplicate-username' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
                null,
                true,
                true,
                false
            ),
            'non-identical-passwords' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'foobar',
                    'passwordVerification'  => 'bazbat',
                ),
            ),
            'invalid-with-enabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
            ),
            'valid-with-disabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                    'passwordVerification'  => 'bazbat',
                ),
                false
            ),
        );
    }

    /**
     * @dataProvider formDataProvider
     * @param        array      $input
     * @param        array|null $output
     * @param        bool       $enableUsername
     * @param        bool       $emailIsUnique
     * @param        bool       $usernameIsUnique
     * @return       void
     */
    public function testInputFilter(
        array $input,
        array $output = null,
        $enableUsername = true,
        $emailIsUnique = true,
        $usernameIsUnique = true
    ) {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $filter = new RegistrationFilter(
            $objectRepository,
            $this->getMockValidator($usernameIsUnique),
            $this->getMockValidator($emailIsUnique),
            new UserOptions(array(
                'enable_username' => $enableUsername,
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
