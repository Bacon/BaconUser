<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication\Authenticator;

use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

/**
 * Authenticator interface.
 */
interface AuthenticatorInterface
{
    /**
     * Tries to authenticate a request.
     *
     * The method has three possible return values:
     *
     * - null, when the request cannot be handled
     * - Error, when authentication did not succeed
     * - scalar (the identity), when authentication succeeded
     *
     * @param  RequestInterface $request
     * @return null|integer|float|string|Error
     */
    public function authenticate(RequestInterface $request);

    /**
     * Creates a challenge response.
     *
     * Should return null if the response is not suitable for the authenticator,
     * a modified Response otherwise.
     *
     * @param  ResponseInterface $response
     * @return null|ResponseInterface
     */
    public function challange(ResponseInterface $response);
}
