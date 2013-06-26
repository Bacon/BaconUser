<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form\Factory;

use BaconUser\Form\UserFieldset;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see UserFieldset}.
 */
class UserFieldsetFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return UserFieldset
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $parentLocator = $serviceLocator->getServiceLocator();
        $options       = $parentLocator->get('BaconUser\Options\UserOptions');

        $fieldset = new UserFieldset($options);
        $fieldset->setHydrator($parentLocator->get('HydratorManager')->get('BaconUser\Hydrator\RegistrationHydrator'));

        return $fieldset;
    }
}
