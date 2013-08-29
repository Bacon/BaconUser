<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\UserInterface;
use Zend\EventManager\Event;

/**
 * Registration event.
 */
class RegistrationEvent extends Event
{
    const EVENT_USER_REGISTERED = 'userRegistered';

    /**
     * $name: defined by Event.
     *
     * @see Event::$name
     * @var string
     */
    protected $name = self::EVENT_USER_REGISTERED;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
