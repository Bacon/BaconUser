<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\PasswordManager\Plugin;

use Zend\Crypt\Password\Bcrypt as BcryptHasher;

class Bcrypt implements PluginInterface, UpgradeCheckInterface
{
    /**
     * @var BcryptHasher
     */
    protected $hasher;

    /**
     * hash(): defined by PluginInterface.
     *
     * @see    PluginInterface::hash()
     * @param  string $password
     * @return string
     */
    public function hash($password)
    {
        return $this->getHasher()->create($password);
    }

    /**
     * compare(): defined by PluginInterface.
     *
     * @see    PluginInterface::compare()
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function compare($password, $hash)
    {
        return $this->getHasher()->verify($password, $hash);
    }

    /**
     * requiresUpgrade(): defined by UpgradeCheckInterface.
     *
     * @see    UpgradeCheckInterface::requiresUpgrade()
     * @param  string $hash
     * @return boolean
     */
    public function requiresUpgrade($hash)
    {
        $cost   = $this->getHasher()->getCost();
        $values = explode('$', $hash);

        if (count($values) < 3) {
            // Something is broken, this hash clearly needs an upgrade.
            return true;
        }

        return ($values[2] !== $cost);
    }

    /**
     * @return BcryptHasher
     */
    public function getHasher()
    {
        if ($this->hasher === null) {
            $this->hasher = new BcryptHasher();
        }

        return $this->hasher;
    }
}
