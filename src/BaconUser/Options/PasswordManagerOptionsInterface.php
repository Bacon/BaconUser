<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Options;

interface PasswordManagerOptionsInterface
{
    /**
     * @return bool
     */
    public function getUpgradePasswords();

    /**
     * @param  bool $upgradePasswords
     * @return PasswordManagerOptionsInterface
     */
    public function setUpgradePasswords($upgradePasswords);

    /**
     * @return string
     */
    public function getDefaultHashingMethod();

    /**
     * @param  string $defaultHashingMethod
     * @return PasswordManagerOptionsInterface
     */
    public function setDefaultHashingMethod($defaultHashingMethod);
}
