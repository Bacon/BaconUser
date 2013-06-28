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
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * User repository.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var ObjectRepository
     */
    protected $userRepository;

    /**
     * @param ObjectRepository $userRepository
     */
    public function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * findOneByEmail(): defined by UserRepositoryInterface.
     *
     * @see    UserRepositoryInterface::findOneByEmail()
     * @param  string $email
     * @return UserInterface|null
     */
    public function findOneByEmail($email)
    {
        return $this->userRepository->findOneBy(array('email' => $email));
    }
}
