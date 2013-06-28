<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Repository;

use BaconUser\Entity\UserInterface;

/**
 * Generic interface for user repositories.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
interface UserRepositoryInterface
{
    /**
     * Finds a single user by email address.
     *
     * @param  string $email
     * @return UserInterface|null
     */
    public function findOneByEmail($email);
}
