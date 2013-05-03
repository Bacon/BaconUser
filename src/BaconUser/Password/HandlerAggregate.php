<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password;

use BaconUser\Password\Options\PasswordHandlerAggregateOptions;
use BaconUser\Password\Options\PasswordHandlerAggregateOptionsInterface;

/**
 * Aggregate password handler for using multiple hashing methods parallely.
 */
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
     * @var PasswordHandlerAggregateOptionsInterface
     */
    protected $options;

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
        return $this->getHandlerByName($this->getOptions()->getDefaultHashingMethod())->hash($password);
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

        if ($this->getOptions()->getMigrateToDefaultHashingMethod()) {
            $defaultHandler = $this->getHandlerByName($this->getOptions()->getDefaultHashingMethod());

            if ($handler !== $defaultHandler) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return HashManager
     */
    public function getHandlerManager()
    {
        if ($this->handlerManager === null) {
            $this->setHandlerManager(new HandlerManager());
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
     * @return PasswordHandlerAggregateOptionsInterface
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->setOptions(new PasswordHandlerAggregateOptions());
        }

        return $this->options;
    }

    /**
     * @param  PasswordHandlerAggregateOptionsInterface $options
     * @return HandlerAggregate
     */
    public function setOptions(PasswordHandlerAggregateOptionsInterface $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param  string $hashingMethod
     * @return HandlerInterface
     */
    protected function getHandlerByName($hashingMethod)
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
    protected function getHandlerByHash($hash)
    {
        foreach ($this->getOptions()->getHashingMethods() as $hashingMethod) {
            $handler = $this->getHandlerByName($hashingMethod);

            if ($handler->supports($hash)) {
                return $handler;
            }
        }

        return null;
    }
}
