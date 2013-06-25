<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Repository;

use BaconUser\Entity\PasswordResetRequest;

/**
 * Interface that acts as an adapter for a concrete repository
 */
interface PasswordResetRepositoryInterface
{
    /**
     * @param  string $email
     * @return PasswordResetRequest|null
     */
    public function findOneByEmail($email);
}
