<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Repository\UserRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see \Doctrine\Common\Persistence\ObjectRepository}.
 */
class UserRepositoryFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return UserRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserRepository(
            $serviceLocator->get('BaconUser\ObjectManager')->getRepository('BaconUser\Entity\User')
        );
    }
}
