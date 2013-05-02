<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password;

/**
 * Interface for password handlers.
 */
interface HandlerInterface
{
    /**
     * Determines whether the implementation supports the given hash.
     *
     * @param  string $hash
     * @return boolean
     */
    public function supports($hash);

    /**
     * Hashes a password.
     *
     * @param  string $password
     * @return string
     */
    public function hash($password);

    /**
     * Compares a password with a hash and returns true if both match, false
     * otherwise.
     *
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash);

    /**
     * Determines whether the hash should be re-hashed.
     *
     * This is used primarily by the authentication adapter, which will verify
     * whether it should re-hash the plain-text password. This is useful if you
     * are migrating to a more secure algorythm, or when the parameters for your
     * current hash changed.
     *
     * @param  string $hash
     * @return boolean
     */
    public function shouldRehash($hash);
}
