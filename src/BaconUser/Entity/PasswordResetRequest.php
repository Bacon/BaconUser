<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Entity;

use DateTime;

/**
 * Entity that stores various information about a password reset request.
 */
class PasswordResetRequest
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var DateTime
     */
    protected $expirationDate;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param  string $token
     * @return PasswordResetRequest
     */
    public function setToken($token)
    {
        $this->token = (string) $token;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getExpirationDate()
    {
        return $this->expirationDate ? clone $this->expirationDate : null;
    }

    /**
     * @param  DateTime $expirationDate
     * @return PasswordResetRequest
     */
    public function setExpirationDate(DateTime $expirationDate)
    {
        $this->expirationDate = clone $expirationDate;
        return $this;
    }

    /**
     * Compares the expiration date to the current time to check if it has expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expirationDate < (new DateTime());
    }
}
