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
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int $id
     * @return UserInterface|null
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return UserInterface[]
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array      $criteria
     * @param  array|null $orderBy
     * @param  int|null   $limit
     * @param  int|null   $offset
     * @return UserInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array $criteria
     * @return UserInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->userRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->userRepository->getClassName();
    }
}
