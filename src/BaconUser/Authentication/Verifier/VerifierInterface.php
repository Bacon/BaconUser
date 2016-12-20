<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication\Verifier;

use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

interface VerifierInterface
{
    /**
     * Tries to authenticate a request.
     *
     * The method has three possible return values:
     *
     * - null, when the request cannot be handled
     * - Error, when verification did not succeed
     * - scalar (the identity), when authentication succeeded
     *
     * @param  RequestInterface $request
     * @return null|integer|float|string|Error
     */
    public function verify(RequestInterface $request, $identity);

    /**
     * Creates a challenge response.
     *
     * Should return null if the response is not suitable for the verifier,
     * a modified Response otherwise.
     *
     * @param  ResponseInterface $response
     * @param  int|float|string  $identity
     * @return null|ResponseInterface
     */
    public function challange(ResponseInterface $response, $identity);
}
