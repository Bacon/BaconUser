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
class ResetPasswordOptions implements ResetPasswordOptionsInterface
{
    /**
     * @var DateInterval
     */
    protected $tokenValidityInterval;

    /**
     * @param  DateInterval|string $tokenValidityInterval
     * @return ResetPasswordOptions
     */
    public function setTokenValidityInterval($tokenValidityInterval)
    {
        if ($tokenValidityInterval instanceof DateInterval) {
            $this->tokenValidityInterval = $tokenValidityInterval;
        } else {
            $this->tokenValidityInterval = DateInterval::createFromDateString($tokenValidityInterval);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenValidityInterval()
    {
        return $this->tokenValidityInterval;
    }
}
