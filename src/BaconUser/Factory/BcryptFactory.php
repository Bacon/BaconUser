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

class BcryptPasswordFactory implements FactoryInterface
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
        $config = $serviceLocator->get('Config');

        if (isset($config['bacon_user']['password']['bcrypt'])) {
            $config = $config['bacon_user']['password']['bcrypt'];

            if (isset($config['cost'])) {
                $bcrypt->getBackend()->setCost($config['cost']);
            }
        }

        return $bcrypt;
    }
}
