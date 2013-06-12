<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form\Factory;

use BaconUser\Form\RegistrationForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RegistrationForm}.
 */
class RegistrationFormFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RegistrationForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $parentLocator = $serviceLocator->getServiceLocator();
        $options       = $parentLocator->get('BaconUser\Options\UserOptions');

        $form = new RegistrationForm($options);
        $form->setHydrator($parentLocator->get('HydratorManager')->get('BaconUser\Hydrator\RegistrationHydrator'));
        $form->setInputFilter($parentLocator->get('InputFilterManager')->get('BaconUser\InputFilter\RegistrationFilter'));

        return $form;
    }
}
