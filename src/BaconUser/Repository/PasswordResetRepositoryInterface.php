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
use BaconUser\Entity\UserInterface;

/**
 * Generic interface for password reset repositories.
 */
interface PasswordResetRepositoryInterface
{
    /**
     * Finds a single password request by user..
     *
     * @param  UserInterface $user
     * @return PasswordResetRequest|null
     */
    public function findOneByUser(UserInterface $user);
}
