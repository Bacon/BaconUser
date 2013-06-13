<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Exception;

class NotFoundException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
     * @param  string $email
     * @param  string $token
     * @return NotFoundException
     */
    public static function notFoundResetPasswordEntity($email, $token)
    {
        return new static(
            sprintf(
                'No reset password request was made for email "%s" and token "%"',
                $email,
                $token
            )
        );
    }
}

