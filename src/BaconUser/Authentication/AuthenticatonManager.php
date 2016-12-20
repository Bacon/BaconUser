<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication;

use BaconUser\Authentication\Authenticator\AuthenticatorInterface;
use BaconUser\Authentication\Policy\PolicyInterface;
use BaconUser\Authentication\Resolver\ResolverInterface;
use BaconUser\Authentication\Verifier\VerifierInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

class AuthenticationManager implements EventManagerAwareInterface
{
    /**
     * Event triggered when a principal was resolved.
     */
    const EVENT_PRINCIPAL_RESOLVED = 'principal-resolved';

    /**
     * Event triggered when the authentication was successful.
     */
    const EVENT_AUTHENTICATION_SUCCEEDED = 'authentication-succeeded';

    /**
     * @var array
     */
    protected $authenticators = array();

    /**
     * @var array
     */
    protected $verifiers = array();

    /**
     * @var PolicyInterface
     */
    protected $policy;

    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * Authenticates a request.
     *
     * The following return values are possible:
     *
     * - null, when no authentication is possible at all
     * - Error, when an authenticator generated an error
     * - ResponseInterface, when the caller needs to return a response
     * - mixed (the principal), when authentication succeeded
     *
     * @param    RequestInterface  $request
     * @param    ResponseInterface $response
     * @return   null|Error|ResponseInterface|mixed
     * @triggers authentication-succeeded
     */
    public function authenticate(RequestInterface $request, ResponseInterface $response)
    {
        if ($this->policy->isVerified()) {
            $principal = $this->resolvePrincipal($this->policy->getIdentity());

            if ($principal !== null) {
                return $principal;
            }
        }

        $identity = $this->determineIdentity($request);

        if ($identity instanceof Error) {
            return $identity;
        } elseif ($identity === null) {
            return $this->generateAuthenticationChallenge($request, $response);
        }

        $verified = $this->verifyIdentity($request, $identity);

        if ($verified instanceof Error) {
            return $verified;
        } elseif (!$verified) {
            return $this->generateVerificationChallenge($request, $response, $identity);
        }

        $principal = $this->resolvePrincipal($identity);

        if (!$principal instanceof Error) {
            $this->getEventManager()->trigger(
                self::EVENT_AUTHENTICATION_SUCCEEDED,
                $this,
                array('principal' => $principal)
            );
        }

        return $principal;
    }

    /**
     * Adds an authenticator to the manager.
     *
     * @param  AuthenticatorInterface $authenticator
     * @return AuthenticatonManager
     */
    public function addAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticators[] = $authenticator;
        return $this;
    }

    /**
     * Adds a verifier to the manager.
     *
     * @param  VerifierInterface $verifier
     * @return AuthenticatonManager
     */
    public function addVerifier(VerifierInterface $verifier)
    {
        $this->verifiers[] = $verifier;
        return $this;
    }

    /**
     * Tries to resolve an identity to a principal.
     *
     * @param    int|float|string $identity
     * @return   null|mixed
     * @triggers principal-resolved
     */
    protected function resolvePrincipal($identity)
    {
        $principal = $this->resolver->resolve($identity);

        if ($principal !== null) {
            $result = $this->getEventManager()->trigger(
                self::EVENT_PRINCIPAL_RESOLVED,
                $this,
                array('principal' => $principal),
                function ($response) {
                    return ($response instanceof Error);
                }
            );

            if ($result->stopped()) {
                return $result->last();
            }

            return $principal;
        }

        return null;
    }

    /**
     * Tries to determine the identity based on the request.
     *
     * @param  RequestInterface $request
     * @return null|int|float|string|Error
     */
    protected function determineIdentity(RequestInterface $request)
    {
        foreach ($this->authenticators as $authenticator) {
            $identity = $authenticator->authenticate($request);

            if ($identity instanceof Error) {
                return $identity;
            } elseif ($identity !== null) {
                $this->policy->remember($identity);
                return $identity;
            }
        }

        return $this->policy->getIdentity();
    }

    /**
     * Tries to verify an identity.
     *
     * @param  ResponseInterface $response
     * @param  int|float|string  $identity
     * @return bool|Error
     */
    protected function verifyIdentity($request, $identity)
    {
        if (!$this->verifiers) {
            $this->policy->setVerified();
            return true;
        }

        foreach ($this->verifiers as $verifier) {
            $verified = $verifier->verify($request, $identity);

            if ($verified instanceof Error) {
                return $verified;
            } elseif ($verified) {
                $this->policy->setVerified();
                return true;
            }
        }

        return false;
    }

    /**
     * Generates an authentication challenge.
     *
     * @param  ResponseInterface $response
     * @return null|ResponseInterface
     */
    protected function generateAuthenticationChallenge(ResponseInterface $response)
    {
        foreach ($this->authenticators as $authenticator) {
            $challenge = $authenticator->challenge($response);

            if ($challenge !== null) {
                return $challenge;
            }
        }

        return null;
    }

    /**
     * Generates a verification challenge.
     *
     * @param  ResponseInterface $response
     * @param  int|float|string  $identity
     * @return null|ResponseInterface
     */
    protected function generateVerificationChallenge(ResponseInterface $response, $identity)
    {
        foreach ($this->verifiers as $verifier) {
            $challenge = $verifier->challenge($response, $identity);

            if ($challenge !== null) {
                return $challenge;
            }
        }

        return null;
    }

    /**
     * Sets the event manager.
     *
     * @param  EventManagerInterface $eventManager
     * @return AuthenticationManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_class($this),
        ));
        $this->events = $eventManager;
        return $this;
    }

    /**
     * Returns the event manager.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if ($this->events === null) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }
}
