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
     * @see ObjectRepository::find()
     *
     * @param int $id The identifier.
     * @return object The object.
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @see ObjectRepository::findAll()
     *
     * @return mixed The objects.
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @see ObjectRepository::findBy()
     *
     * @throws \UnexpectedValueException
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return mixed The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @see ObjectRepository::findOneBy()
     *
     * @param array $criteria
     * @return object The object.
     */
    public function findOneBy(array $criteria)
    {
        return $this->userRepository->findOneBy($criteria);
    }

    /**
     * @see ObjectRepository::getClassName()
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->userRepository->getClassName();
    }
}
