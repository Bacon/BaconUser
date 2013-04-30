<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password;

use Zend\Crypt\Password\Bcrypt as BcryptHasher;

/**
 * Password hashing handler backed by Bcrypt.
 */
class Bcrypt implements HandlerInterface
{
    /**
     * @var BcryptHasher
     */
    protected $backend;

    /**
     * supports(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::supports()
     * @param  string $hash
     * @return boolean
     */
    public function supports($hash)
    {
        return (bool) preg_match('(^\$2[axy]?\$\d{2}\$[./a-zA-Z0-9]{53}$)', $hash);
    }

    /**
     * hash(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::hash()
     * @param  string $password
     * @return string
     */
    public function hash($password)
    {
        return $this->getBackend()->create($password);
    }

    /**
     * compare(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::compare()
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash)
    {
        return $this->getBackend()->verify($password, $hash);
    }

    /**
     * shouldRehash(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::shouldRehash()
     * @param  string $hash
     * @return boolean
     */
    public function shouldRehash($hash)
    {
        $cost   = $this->getBackend()->getCost();
        $values = explode('$', $hash);

        if (count($values) < 3) {
            // Something is broken, this hash clearly needs to be re-hashed.
            return true;
        }

        return ($values[2] !== $cost);
    }

    /**
     * @return BcryptHasher
     */
    public function getBackend()
    {
        if ($this->backend === null) {
            $this->backend = new BcryptHasher();
        }

        return $this->backend;
    }

    /**
     * @param  BcryptHasher $backend
     * @return Bcrypt
     */
    public function setBackend(BcryptHasher $backend)
    {
        $this->backend = $backend;
        return $this;
    }
}
