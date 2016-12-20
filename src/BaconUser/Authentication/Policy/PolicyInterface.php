<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication\Policy;

/**
 * Policy interface.
 */
interface PolicyInterface
{
    /**
     * Gets the stored identity.
     *
     * @return int|float|string
     */
    public function getIdentity();

    /**
     * Remembers an identity.
     *
     * Must set the verified flag to false.
     *
     * @param  int|float|string $identity
     * @return void
     */
    public function remember($identity);

    /**
     * Forgets the currently stored identity.
     *
     * @return void
     */
    public function forget();

    /**
     * Changes the stored identity to verified.
     *
     * @return void
     */
    public function setVerified();

    /**
     * Returns whether the stored identity is verified.
     *
     * @return bool
     */
    public function isVerified();
}
