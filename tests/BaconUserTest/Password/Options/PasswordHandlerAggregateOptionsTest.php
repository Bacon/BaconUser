<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Password\Options\PasswordHandlerAggregateOptions;

use BaconUser\Password\Options\PasswordHandlerAggregateOptions;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Password\Options\PasswordHandlerAggregateOptions
 */
class PasswordHandlerAggregateOptionsTest extends TestCase
{
    public function testDefaults()
    {
        $options = new PasswordHandlerAggregateOptions();
        $this->assertEquals(array('Bcrypt', 'SimpleSha1', 'SimpleMd5'), $options->getHashingMethods());
        $this->assertEquals('bcrypt', $options->getDefaultHashingMethod());
        $this->assertTrue($options->getMigrateToDefaultHashingMethod(), 'migrate_to_default_hashing_method must default to true');
    }

    public function testSetValues()
    {
        $options = new PasswordHandlerAggregateOptions(array(
            'hashing_methods'                   => array('SimpleSha1'),
            'default_hashing_method'            => 'simplesha1',
            'migrate_to_default_hashing_method' => false,
        ));

        $this->assertEquals(array('SimpleSha1'), $options->getHashingMethods());
        $this->assertEquals('simplesha1', $options->getDefaultHashingMethod());
        $this->assertFalse($options->getMigrateToDefaultHashingMethod(), 'migrate_to_default_hashing_method must be false');
    }
}
