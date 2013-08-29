<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password;

use BaconUser\Exception;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Plugin manager for {@see HandlerAggregate}.
 */
class HandlerManager extends AbstractPluginManager
{
    /**
     * $invokableClasses: defined by AbstractPluginManager.
     *
     * @see AbstractPluginManager::$invokableClasses
     * @var array
     */
    protected $invokableClasses = array(
        'simplemd5'  => 'BaconUser\Password\SimpleMd5',
        'simplesha1' => 'BaconUser\Password\SimpleSha1',
    );

    /**
     * $factories: defined by AbstractPluginManager.
     *
     * @see AbstractPluginManager::$factories
     * @var array
     */
    protected $factories = array(
        'bcrypt' => 'BaconUser\Password\Factory\BcryptFactory',
    );

    /**
     * validatePlugin(): defined by AbstractPluginManager.
     *
     * @see    AbstractPluginManager::validatePlugin()
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof HandlerInterface) {
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\HandlerInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
