<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class RegistrationFormHydrator extends ClassMethods
{
    /**
     * __construct(): defined by ClassMethods.
     *
     * @see   ClassMethods::__construct()
     * @param bool             $underscoreSeparatedKeys
     * @param PasswordStrategy $passwordStrategy
     */
    public function __construct($underscoreSeparatedKeys = true, StrategyInterface $passwordHashingStrategy = null)
    {
        parent::__construct($underscoreSeparatedKeys);

        if ($passwordHashingStrategy !== null) {
            $this->addStrategy('password_hash', $passwordHashingStrategy);
        }
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

        parent::hydrate($data, $object);
    }
}
