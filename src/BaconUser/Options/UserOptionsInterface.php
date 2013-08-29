<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Options;

/**
 * General user options.
 */
interface UserOptionsInterface
{
    /**
     * Returns whether username are enabled.
     *
     * If disabled, email addresses will be used for identification.
     *
     * @return bool
     */
    public function getEnableUsername();

    /**
     * Returns whether user states are enabled.
     *
     * These are useful to keep track of email confirmation or disabled users.
     *
     * @return bool
     */
    public function getEnableUserState();

    /**
     * Returns the default user state after registration.
     *
     * @return int
     */
    public function getDefaultUserState();

    /**
     * Returns the allowed login states.
     *
     * @return array
     */
    public function getAllowedLoginStates();
}
