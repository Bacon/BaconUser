<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Factory;

use BaconUser\Password\Bcrypt;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Service factory that instantiates {@see Bcrypt}.
 */
class BcryptFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Bcrypt
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $bcrypt = new Bcrypt();

        if ($serviceLocator instanceof AbstractPluginManager) {
            $config = $serviceLocator->getServiceLocator()->get('BaconUser\Config');
        } else {
            $config = $serviceLocator->get('BaconUser\Config');
        }

        if (isset($config['password']['bcrypt'])) {
            $config = $config['password']['bcrypt'];

            if (isset($config['cost'])) {
                $bcrypt->getBackend()->setCost($config['cost']);
            }
        }

        return $bcrypt;
    }
}
