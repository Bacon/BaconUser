<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\PasswordManager;

use BaconUser\Options\PasswordManagerOptions;
use BaconUser\Options\PasswordManagerOptionsInterface;

class PasswordManager
{
    /**
     * @var PluginManager
     */
    protected $pluginManager;

    /**
     * @var array
     */
    protected $pluginCache = array();

    /**
     * @var PasswordManagerOptionsInterface
     */
    protected $options;

    /**
     * Hashes a password with a given hashing method.
     *
     * When no hashing method is given, the default will be used.
     *
     * @param  string      $password
     * @param  string|null $hashingMethod
     * @return string
     */
    public function hash($password, $hashingMethod = null)
    {
        if ($hashingMethod === null) {
            $hashingMethod = $this->getOptions()->getDefaultHashingMethod();
        }

        return $this->getPlugin($hashingMethod)->hash($password);
    }

    /**
     * Compares a password with a hash with a given hashing method.
     *
     * @param  string $password
     * @param  string $hash
     * @param  string $hashingMethod
     * @return boolean
     */
    public function compare($password, $hash, $hashingMethod)
    {
        return $this->getPlugin($hashingMethod)->compare($password, $hash);
    }

    /**
     * Determines if a hash with a given hashing method needs an upgrade.
     *
     * @param  string $hash
     * @param  string $hashingMethod
     * @return boolean
     */
    public function requiresUpgrade($hash, $hashingMethod)
    {
        $options = $this->getOptions();

        if (!$options->getUpgradePasswords()) {
            return false;
        } elseif ($hashingMethod !== $options->getDefaultHashingMethod()) {
            return true;
        }

        $plugin = $this->getPlugin($hashingMethod);

        if ($plugin instanceof Plugin\UpgradeCheckInterface && $plugin->requiresUpgrade($hash)) {
            return true;
        }

        return false;
    }

    /**
     * @param  string $hashingMethod
     * @return BaconUser\PasswordManager\Plugin\PluginInterface
     */
    protected function getPlugin($hashingMethod)
    {
        if (!isset($this->pluginCache[$hashingMethod])) {
            $this->pluginCache[$hashingMethod] = $this->getPluginManager()->get($type);
        }

        return $this->pluginCache[$hashingMethod];
    }

    /**
     * @return PluginManager
     */
    public function getPluginManager()
    {
        if ($this->pluginManager === null) {
            $this->pluginManager = new PluginManager();
        }

        return $this->pluginManager;
    }

    /**
     * @param  PluginManager $pluginManager
     * @return PasswordManager
     */
    public function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
        return $this;
    }

    /**
     * @return PasswordManagerOptionsInterface
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->setOptions(new PasswordManagerOptions());
        }

        return $this->options;
    }

    /**
     * @param  PasswordManagerOptionsInterface $options
     * @return PasswordManager
     */
    public function setOptions(PasswordManagerOptionsInterface $options)
    {
        $this->options = $options;
        return $this;
    }
}
