<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form;

use BaconUser\Password\HandlerInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * Hydration strategy for hashing passwords.
 */
class PasswordHashingStrategy implements StrategyInterface
{
    /**
     * @var HandlerInterface
     */
    protected $handler;

    /**
     * @param HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * extract(): defined by StrategyInterface.
     *
     * As there is naturally no way to convert a hash back to a password, this
     * method always returns an empty string.
     *
     * @see    StrategyInterface::extract()
     * @param  string $value
     * @return string
     */
    public function extract($value)
    {
        return '';
    }

    /**
     * hydrate(): defined by StrategyInterface.
     *
     * @see    StrategyInterface::hydrate()
     * @param  string $value
     * @return string
     */
    public function hydrate($value)
    {
        return $this->handler->hash($value);
    }
}
