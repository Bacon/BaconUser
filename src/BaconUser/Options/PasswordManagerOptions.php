<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Options;

use BaconUser\Exception;
use Zend\Stdlib\AbstractOptions;

class PasswordManagerOptions extends AbstractOptions implements PasswordManagerOptionsInterface
{
    /**
     * Disable strict option mode.
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * @var bool
     */
    protected $upgradePasswords = true;

    /**
     * @var string
     */
    protected $defaultHashingMethod = 'bcrypt';

    /**
     * @return bool
     */
    public function getUpgradePasswords()
    {
        return $this->upgradePasswords;
    }

    /**
     * @param  bool $upgradePasswords
     * @return PasswordManagerOptionsInterface
     */
    public function setUpgradePasswords($upgradePasswords)
    {
        $this->upgradePasswords = (bool) $upgradePasswords;
    }

    /**
     * @return string
     */
    public function getDefaultHashingMethod()
    {
        return $this->defaultHashingMethod;
    }

    /**
     * @param  string $defaultHashingMethod
     * @return PasswordManagerOptionsInterface
     */
    public function setDefaultHashingMethod($defaultHashingMethod)
    {
        $this->defaultHashingMethod = $defaultHashingMethod;
    }
}
