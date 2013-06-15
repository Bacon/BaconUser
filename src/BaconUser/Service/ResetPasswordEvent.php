<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\ResetPassword;
use Zend\EventManager\Event;

/**
 * Event triggers
 */
class ResetPasswordEvent extends Event
{
    const EVENT_CREATED = 'resetPasswordCreated';

    /**
     * @var string
     */
    protected $name = self::EVENT_CREATED;

    /**
     * @var ResetPassword
     */
    protected $resetPassword;

    /**
     * @param ResetPassword $resetPassword
     */
    public function __construct(ResetPassword $resetPassword)
    {
        $this->resetPassword = $resetPassword;
    }

    /**
     * @return ResetPassword
     */
    public function getResetPassword()
    {
        return $this->resetPassword;
    }
}
