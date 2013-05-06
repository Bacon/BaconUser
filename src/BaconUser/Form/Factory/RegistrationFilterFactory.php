<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form\Factory;

use BaconUser\Form\RegistrationFilter;
use DoctrineModule\Validator\NoObjectExists;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationFilter}.
 */
class RegistrationFilterFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userRepository = $serviceLocator->get('BaconUser\Repository\UserRepository');
        $options        = $serviceLocator->get('BaconUser\Options\UserOptions');

        $inputFilter = new RegistrationFilter(
            new NoObjectExists(array(
                'object_repository' => $userRepository,
                'fields'            => 'email',
            )),
            new NoObjectExists(array(
                'object_repository' => $userRepository,
                'fields'            => 'username',
            )),
            $options
        );

        return $inputFilter;
    }
}
