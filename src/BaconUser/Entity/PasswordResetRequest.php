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
 * Entity that stores various information about a password reset request
 */
class PasswordResetRequest
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var DateTime
     */
    protected $expirationDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param  string $email
     * @return PasswordResetRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
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
        $this->token = $token;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpirationDate()
    {
        return clone $this->expirationDate;
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
     * Compares the expiration date to the current time in order to check if it has expired
     *
     * @return bool
     */
    public function hasTokenExpired()
    {
        return $this->expirationDate < (new DateTime());
    }
}
