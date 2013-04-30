<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\PasswordManager\Plugin;

interface UpgradeCheckInterface
{
    /**
     * Determines whether a hash with a given hashing methods needs to be
     * upgrades by the plugin.
     *
     * @param  string $hash
     * @return boolean
     */
    public function requiresUpgrade($hash);
}
