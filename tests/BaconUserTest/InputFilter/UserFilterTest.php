<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\InputFilter;

use BaconUser\InputFilter\UserFilter;
use BaconUser\Options\UserOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\InputFilter\UserFilter
 */
class UserFilterTest extends TestCase
{
    public static function formDataProvider()
    {
        return array(
            'completely-valid-input' => array(
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                ),
            ),
            'space-padded-valid-input' => array(
                array(
                    'username'              => ' foobar ',
                    'email'                 => ' foobar@example.com ',
                    'password'              => 'bazbat',
                ),
                array(
                    'username'              => 'foobar',
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                ),
            ),
            'invalid-with-enabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                ),
            ),
            'valid-with-disabled-username' => array(
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
                ),
                array(
                    'email'                 => 'foobar@example.com',
                    'password'              => 'bazbat',
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
     * @return       void
     */
    public function testInputFilter(
        array $input,
        array $output = null,
        $enableUsername = true
    ) {
        $filter = new UserFilter(
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
    /*protected function getMockValidator($validates)
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
    }*/
}
