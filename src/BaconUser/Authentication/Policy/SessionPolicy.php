<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication\Policy;

use Zend\Session\Container as SessionContainer;
use Zend\Session\ManagerInterface;

/**
 * Session policy.
 */
class SessionPolicy implements PolicyInterface
{
    /**
     * Default session namespace.
     */
    const DEFAULT_NAMESPACE = 'baconuser_authentication';

    /**
     * @var SessionContainer
     */
    protected $session;

    /**
     * @param string|null      $namespace
     * @param ManagerInterface $manager
     */
    public function __construct($namespace = null, ManagerInterface $manager = null)
    {
        if ($namespace === null) {
            $namespace = self::DEFAULT_NAMESPACE;
        }

        $this->session = new SessionContainer($namespace, $manager);
    }

    /**
     * getIdentity(): defined by PolicyInterface.
     *
     * @see    PolicyInterface::getIdentity()
     * @return string
     */
    public function getIdentity()
    {
        return $this->session->identity;
    }

    /**
     * remember(): defined by PolicyInterface.
     *
     * @see    PolicyInterface::remember()
     * @param  int|float|string $identity
     * @return void
     */
    public function remember($identity)
    {
        $this->session->identity = $identity;
        $this->session->verified = false;
    }

    /**
     * forget(): defined by PolicyInterface.
     *
     * @see    PolicyInterface::forget()
     * @return void
     */
    public function forget()
    {
        unset($this->session->identity);
    }

    /**
     * setVerified(): defined by PolicyInterface.
     *
     * @see    PolicyInterface::setVerified()
     * @return void
     */
    public function setVerified()
    {
        $this->session->verified = true;
    }

    /**
     * isVerified(): defined by PolicyInterface.
     *
     * @see    PolicyInterface::isVerified()
     * @return bool
     */
    public function isVerified()
    {
        return (bool) $this->session->verified;
    }
}
