<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Options;

use DateInterval;

/**
 * General options for password resets
 */
interface PasswordResetOptionsInterface
{
    /**
     * Get the interval for which the token is considered as valid
     *
     * @return DateInterval
     */
    public function getTokenValidityInterval();
}
