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
class UserRepository implements UserRepositoryInterface, ObjectRepository
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

    /**
     * @see ObjectRepository::find()
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @see ObjectRepository::findAll()
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @see ObjectRepository::findBy()
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @see ObjectRepository::findOneBy()
     */
    public function findOneBy(array $criteria)
    {
        return $this->userRepository->findBy($criteria);
    }

    /**
     * @see ObjectRepository::getClassName()
     */
    public function getClassName()
    {
        return $this->userRepository->getClassName();
    }
}
