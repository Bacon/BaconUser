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

class UserServiceOptions extends AbstractOptions implements UserServiceOptionsInterface
{
    /**
     * Disable strict option mode.
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $userEntityClass = 'BaconUser\Entity\User';

    /**
     * @return string
     */
    public function getUserEntityClass()
    {
        return $this->userEntityClass;
    }

    /**
     * @param  string $userEntityClass
     * @return ModuleOptions
     * @throws Exception\InvalidArgumentException
     */
    public function setUserEntityClass($userEntityClass)
    {
        if (!is_subclass_of($userEntityClass, 'BaconUser\Entity\UserInterface')) {
            throw new Exception\InvalidArgumentException('%s does not implement BaconUser\Entity\UserInterface');
        }

        $this->userEntityClass = $userEntityClass;
        return $this;
    }
}
