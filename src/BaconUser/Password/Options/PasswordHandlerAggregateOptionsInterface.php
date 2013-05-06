<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password\Options;

/**
 * Options for the password aggregate handler.
 */
interface PasswordHandlerAggregateOptionsInterface
{
    /**
     * @return array
     */
    public function getHashingMethods();

    /**
     * @param  array $hashingMethods
     * @return PasswordHandlerAggregateOptions
     */
    public function setHashingMethods(array $hashingMethods);

    /**
     * @return string
     */
    public function getDefaultHashingMethod();

    /**
     * @param  string $defaultHashingMethod
     * @return PasswordHandlerAggregateOptions
     */
    public function setDefaultHashingMethod($defaultHashingMethod);

    /**
     * @return bool
     */
    public function getMigrateToDefaultHashingMethod();

    /**
     * @param  bool $migrateToDefaultHashingMethod
     * @return PasswordHandlerAggregateOptions
     */
    public function setMigrateToDefaultHashingMethod($migrateToDefaultHashingMethod);
}
