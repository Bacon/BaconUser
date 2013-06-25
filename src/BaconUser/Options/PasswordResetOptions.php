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
use Zend\Stdlib\AbstractOptions;

/**
 * General options for password resets
 */
class PasswordResetOptions extends AbstractOptions implements PasswordResetOptionsInterface
{
    /**
     * @var DateInterval|string
     */
    protected $tokenValidityInterval = '+24 hours';

    /**
     * @param  DateInterval|string $tokenValidityInterval
     * @return PasswordResetOptions
     */
    public function setTokenValidityInterval($tokenValidityInterval)
    {
        $this->tokenValidityInterval = $tokenValidityInterval;
        return $this;
    }

    /**
     * @return DateInterval
     */
    public function getTokenValidityInterval()
    {
        if (!$this->tokenValidityInterval instanceof DateInterval) {
            $this->tokenValidityInterval = DateInterval::createFromDateString($this->tokenValidityInterval);
        }

        return $this->tokenValidityInterval;
    }
}
