<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\PasswordManager\Plugin;

class Md5 implements PluginInterface
{
    /**
     * hash(): defined by PluginInterface.
     *
     * @see    PluginInterface::hash()
     * @param  string $password
     * @return string
     */
    public function hash($password)
    {
        return md5($password);
    }

    /**
     * compare(): defined by PluginInterface.
     *
     * @see    PluginInterface::compare()
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash)
    {
        return (md5($password) === $hash);
    }
}
