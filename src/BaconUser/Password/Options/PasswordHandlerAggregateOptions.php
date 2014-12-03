<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Password\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @see PasswordHandlerAggregateOptionsInterface
 */
class PasswordHandlerAggregateOptions extends AbstractOptions implements PasswordHandlerAggregateOptionsInterface
{
    /**
     * @var array
     */
    protected $hashingMethods = array(
        'Bcrypt',
        'SimpleSha1',
        'SimpleMd5',
    );

    /**
     * @var string
     */
    protected $defaultHashingMethod = 'bcrypt';

    /**
     * @var bool
     */
    protected $migrateToDefaultHashingMethod = true;

    /**
     * @return array
     */
    public function getHashingMethods()
    {
        return $this->hashingMethods;
    }

    /**
     * @param  array $hashingMethods
     * @return \BaconUser\Password\HandlerAggregate
     */
    public function setHashingMethods(array $hashingMethods)
    {
        $this->hashingMethods = $hashingMethods;
        return $this;
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
     * @return \BaconUser\Password\HandlerAggregate
     */
    public function setDefaultHashingMethod($defaultHashingMethod)
    {
        $this->defaultHashingMethod = $defaultHashingMethod;
        return $this;
    }

    /**
     * @return bool
     */
    public function getMigrateToDefaultHashingMethod()
    {
        return $this->migrateToDefaultHashingMethod;
    }

    /**
     * @param  bool $migrateToDefaultHashingMethod
     * @return \BaconUser\Password\HandlerAggregate
     */
    public function setMigrateToDefaultHashingMethod($migrateToDefaultHashingMethod)
    {
        $this->migrateToDefaultHashingMethod = (bool) $migrateToDefaultHashingMethod;
        return $this;
    }
}
