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
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * {@inheritDoc}
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = (string) $passwordHash;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function setUsername($username)
    {
        $this->username = ($username === null ? null : (string) $username);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritDoc}
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = ($displayName === null ? null : (string) $displayName);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritDoc}
     */
    public function setState($state)
    {
        $this->state = ($state === null ? null : (int) $state);
        return $this;
    }
}
