<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Entity;

/**
 * @see UserInterface
 */
class User implements UserInterface
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
    protected $passwordHash;

    /**
     * @var string|null
     */
    protected $username;

    /**
     * @var string|null
     */
    protected $displayName;

    /**
     * @var int|null
     */
    protected $state;

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
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param  string $passwordHash
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = (string) $passwordHash;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param  null|string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = ($username === null ? null : (string) $username);
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param  null|string $displayName
     * @return User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = ($displayName === null ? null : (string) $displayName);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param  int|null $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = ($state === null ? null : (int) $state);
        return $this;
    }
}
