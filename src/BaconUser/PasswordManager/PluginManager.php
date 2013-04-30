<?php
namespace BaconUser\PasswordManager;

use BaconUser\Exception;
use Zend\ServiceManager\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{
    /**
     * validatePlugin(): defined by AbstractPluginManager.
     *
     * @see    AbstractPluginManager::validatePlugin()
     * @param  mixed $plugin
     * @return void
     * @throws RuntimeException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof Plugin\PluginInterface) {
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Plugin\PluginInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
