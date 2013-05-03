<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Form\RegistrationForm;
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
        $options = $serviceLocator->get('BaconUser\Options\RegistrationOptions');

        $form = new RegistrationForm(null, $options);
        $form->setHydrator($serviceLocator->get('BaconUser\Form\RegistrationFormHydrator'));
        $form->setInputFilter($serviceLocator->get('BaconUser\Form\RegistrationFormFilter'));

        return $form;
    }
}
