<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\PasswordManager\Plugin;

interface PluginInterface
{
    /**
     * Hashes a password.
     *
     * @param  string $password
     * @return string
     */
    public function hash($password);

    /**
     * Compares a password with a hash.
     *
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash);
}
