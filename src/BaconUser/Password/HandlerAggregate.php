<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password;

class HandlerAggregate implements HandlerInterface
{
    /**
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * @var array
     */
    protected $handlerCache = array();

    /**
     * @var array
     */
    protected $hashingMethods = array(
        'bcrypt',
        'simple-sha1',
        'simple-md5',
    );

    /**
     * @var string
     */
    protected $defaultHashingMethod = 'bcrypt';

    /**
     * @var bool
     */
    protected $migrateToDefaultHashingMethod = true;

    /**
     * supports(): defined by HandlerInterface.
     *
     * @see    HandlerInterface::supports()
     * @param  string $hash
     * @return boolean
     */
    public function supports($hash)
    {
        return ($this->getHandlerByHash($hash) !== null);
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
        return $this->getHandlerByName($this->getDefaultHashingMethod())->hash($password);
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
        $handler = $this->getHandlerByHash($hash);

        if ($handler === null) {
            return false;
        }

        return $handler->compare($password, $hash);
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
        $handler = $this->getHandlerByHash($hash);

        if ($handler === null) {
            // Hash is not uspported by any method, migration recommended.
            return true;
        }

        if ($handler->shouldRehash($hash)) {
            return true;
        }

        if ($this->getMigrateToDefaultHashingMethod()) {
            $defaultHandler = $this->getHandlerByName($this->getDefaultHashingMethod());

            if ($handler !== $defaultHandler) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string $hashingMethod
     * @return HandlerInterface
     */
    public function getHandlerByName($hashingMethod)
    {
        if (!isset($this->hashCache[$hashingMethod])) {
            $this->hashCache[$hashingMethod] = $this->getHandlerManager()->get($hashingMethod);
        }

        return $this->hashCache[$hashingMethod];
    }

    /**
     * @param  string $hash
     * @return HandlerInterface
     */
    public function getHandlerByHash($hash)
    {
        foreach ($this->getHashingMethods() as $hashingMethod) {
            $handler = $this->getHandlerByName($hashingMethod);

            if ($handler->supports($hash)) {
                return $handler;
            }
        }

        return null;
    }

    /**
     * @return HashManager
     */
    public function getHandlerManager()
    {
        if ($this->handlerManager === null) {
            $this->handlerManager = new HandlerManager();
        }

        return $this->handlerManager;
    }

    /**
     * @param  HandlerManager $handlerManager
     * @return HandlerAggregate
     */
    public function setHandlerManager(HandlerManager $handlerManager)
    {
        $this->handlerManager = $handlerManager;
        return $this;
    }

    /**
     * @return array
     */
    public function getHashingMethods()
    {
        return $this->hashingMethods;
    }

    /**
     * @param  array $hashingMethods
     * @return HandlerAggregate
     */
    public function setHashingMethods(array $hashingMethods)
    {
        $this->hashingMethods = $hashingMethods;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultHashingMethod()
    {
        return $this->defaultHashingMethod;
    }

    /**
     * @param  string $defaultHashingMethod
     * @return HandlerAggregate
     */
    public function setDefaultHashingMethod($defaultHashingMethod)
    {
        $this->defaultHashingMethod = $defaultHashingMethod;
        return $this;
    }

    /**
     * @return bool
     */
    public function getMigrateToDefaultHashingMethod()
    {
        return $this->migrateToDefaultHashingMethod;
    }

    /**
     * @param  bool $migrateToDefaultHashingMethod
     * @return HandlerAggregate
     */
    public function setMigrateToDefaultHashingMethod($migrateToDefaultHashingMethod)
    {
        $this->migrateToDefaultHashingMethod = (bool) $migrateToDefaultHashingMethod;
        return $this;
    }
}
