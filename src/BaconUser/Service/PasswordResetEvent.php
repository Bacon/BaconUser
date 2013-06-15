<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\PasswordResetRequest;
use Zend\EventManager\Event;

/**
 * Event triggers
 */
class PasswordResetEvent extends Event
{
    const EVENT_CREATED = 'passwordResetCreated';

    /**
     * @var string
     */
    protected $name = self::EVENT_CREATED;

    /**
     * @var PasswordResetRequest
     */
    protected $passwordResetRequest;

    /**
     * @param PasswordResetRequest $passwordResetRequest
     */
    public function __construct(PasswordResetRequest $passwordResetRequest)
    {
        $this->passwordResetRequest = $passwordResetRequest;
    }

    /**
     * @return PasswordResetRequest
     */
    public function getPasswordResetRequest()
    {
        return $this->passwordResetRequest;
    }
}
