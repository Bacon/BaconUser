<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * Hydrator for the {@see RegistrationForm}.
 */
class RegistrationHydrator extends ClassMethods
{
    /**
     * @param StrategyInterface $passwordHashingStrategy
     */
    public function __construct(StrategyInterface $passwordHashingStrategy)
    {
        parent::__construct(true);
        $this->addStrategy('password_hash', $passwordHashingStrategy);
    }

    /**
     * hydrate(): defined by ClassMethods.
     *
     * @see    ClassMethods::hydrate()
     * @param  array  $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (isset($data['password'])) {
            $data['password_hash'] = $data['password'];
        }

        return parent::hydrate($data, $object);
    }
}
