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
 * Fallback for old databases with simple MD5 hashes.
 *
 * This handler can be used with old databases which have their passwords hashed
 * with MD5. To make the hashes in your database compatible with this handler,
 * simply prefix all password hashes with "$simple-md5$".
 */
class SimpleMd5 implements HandlerInterface
{
    /**
     * supports(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::supports()
     * @param  string $hash
     * @return boolean
     */
    public function supports($hash)
    {
        return (bool) preg_match('(^\$simple-md5\$[a-zA-Z0-9]{32}$)', $hash);
    }

    /**
     * hash(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::hash()
     * @param  string $password
     * @return string
     */
    public function hash($password)
    {
        return '$simple-md5$' . md5($password);
    }

    /**
     * compare(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::compare()
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash)
    {
        return ('$simple-md5$' . md5($password) === $hash);
    }

    /**
     * shouldRehash(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::shouldRehash()
     * @param  string $hash
     * @return boolean
     */
    public function shouldRehash($hash)
    {
        return false;
    }
}
