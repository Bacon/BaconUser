<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser;

use Zend\ServiceManager\Config as ServiceManagerConfig;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'baconuser_passwordmanager_passwordmanager' => function ($sm) {
                    $passwordManager = new PasswordManager\PasswordManager();
                    $passwordManager->setPluginManager($sm->get('baconuser_passwordmanager_pluginmanager'));
                    return $passwordManager;
                },
                'baconuser_passwordmanager_pluginmanager' => function ($sm) {
                    $config = $sm->get('Config');
                    if (isset($config['bacon_user']['password_manager']['plugins'])) {
                        $pluginConfig = new ServiceManagerConfig($config['bacon_user']['password_manager']['plugins']);
                    } else {
                        $pluginConfig = null;
                    }
                    return new PasswordManager\PluginManager($pluginConfig);
                },
            ),
        );
    }

    public function getLiquibasePath()
    {
        return __DIR__ . '/liquibase/changelog.xml';
    }
}
