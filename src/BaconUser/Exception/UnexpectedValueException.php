<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Exception;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
     * @param  mixed $user
     * @return UnexpectedValueException
     */
    public static function invalidUserEntity($user)
    {
        return new static(
            sprintf(
                '%s does not implement BaconUser\Entity\UserInterface',
                is_object($user) ? get_class($user) : gettype($user)
            )
        );
    }
}
