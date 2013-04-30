<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Service;

use BaconUser\Entity\User;
use BaconUser\Options\UserServiceOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserService implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var UserServiceOptionsInterface
     */
    protected $options;

    /**
     * Registers a new user.
     *
     * @param  array $data
     * @return User
     */
    public function register(array $data)
    {
        $class = $this->getOptions()->getUserEntityClass();
        $user  = new $class();
        $user->setEmail('mail@dasprids.de');
        $user->setUsername('dasprid');
        $user->setPassword('dasprid');

        $this->getObjectManager()->persist($user);
        $this->getObjectManager()->flush();

        return $user;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param  ServiceManager $serviceManager
     * @return UserService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        if ($this->objectManager === null) {
            $this->setObjectManager($this->getServiceManager()->get('doctrine.entitymanager.orm_default'));
        }

        return $this->entityManager;
    }

    /**
     * @param  ObjectManager $objectManager
     * @return UserService
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

    /**
     * @return UserServiceOptionsInterface
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->setOptions($this->getServiceManager()->get('baconuser_module_options'));
        }

        return $this->options;
    }

    /**
     * @param  UserServiceOptionsInterface $options
     * @return UserService
     */
    public function setOptions(UserServiceOptionsInterface $options)
    {
        $this->options = $options;
        return $this;
    }
}
