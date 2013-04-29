<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconStringUtils For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * User service.
 */
class UserService implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Registers a new user.
     *
     * @param  array $data
     * @return User
     */
    public function register(array $data)
    {
        $user = new User();
        $user->getEmail('mail@dasprids.de');
        $user->setUsername('dasprid');

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * getServiceManager(): defined by ServiceManagerAwareInterface.
     *
     * @see    ServiceManagerAwareInterface::getServiceManager()
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * setServiceManager(): defined by ServiceManagerAwareInterface.
     *
     * @see    ServiceManagerAwareInterface::setServiceManager()
     * @param  ServiceManager $serviceManager
     * @return UserService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Gets the entity manager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if ($this->entityManager === null) {
            $this->entityManager = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
        }

        return $this->entityManager;
    }

    /**
     * Sets the entity manager.
     *
     * @param  EntityManager $entityManager
     * @return UserService
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
