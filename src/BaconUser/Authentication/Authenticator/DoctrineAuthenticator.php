<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Authentication\Authenticator;

use BaconUser\Authentication\Error;
use BaconUser\Password\HandlerInterface;
use BaconUser\Options\UserOptionsInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;

/**
 * Authenticator for handling logins with doctrine.
 */
class DoctrineAuthenticator implements AuthenticatorInterface, EventManagerAwareInterface
{
    /**
     * Event triggered when the authentication was successful.
     */
    const EVENT_AUTHENTICATION_SUCCEEDED = 'authentication-succeeded';

    /**
     * @var ObjectRepository
     */
    protected $userRepository;

    /**
     * @var HandlerInterface
     */
    protected $passwordHandler;

    /**
     * @var UserOptionsInterface
     */
    protected $options;

    /**
     * @var string
     */
    protected $identityField = 'identity';

    /**
     * @var string
     */
    protected $passwordField = 'password';

    /**
     * @param ObjectRepository $userRepository
     * @param HandlerInterface $passwordHandler
     */
    public function __construct(
        ObjectRepository     $userRepository,
        HandlerInterface     $passwordHandler,
        UserOptionsInterface $options
    ) {
        $this->userRepository  = $userRepository;
        $this->passwordHandler = $passwordHandler;
        $this->options         = $options;
    }

    /**
     * authenticate(): defined by AuthenticatorInterface.
     *
     * @see      AuthenticatorInterface::authenticate()
     * @param    RequestInterface $request
     * @return   null|Error|\BaconUser\Entity\UserInterface
     * @triggers authentication-succeeded
     */
    public function authenticate(RequestInterface $request)
    {
        if (!$request instanceof HttpRequest) {
            return null;
        }

        $identity = $request->getPost($this->identityField);
        $password = $request->getPost($this->passwordField);

        if ($identity === null || $password === null) {
            return null;
        }

        if ($this->options->getEnableUsername()) {
            $criteria = array('username' => $identity);
        } else {
            $criteria = array('email' => $identity);
        }

        $user = $this->userRepository->findOneBy($criteria);

        if ($user === null) {
            return new Error('No matching record found.');
        }

        if (!$this->passwordHandler->compare($password, $user->getPasswordHash())) {
            return new Error('Password is invalid.');
        }

        $this->getEventManager()->trigger(
            self::EVENT_AUTHENTICATION_SUCCEEDED,
            $this,
            array(
                'user'             => $user,
                'identity'         => $identity,
                'password'         => $password,
                'password_handler' => $this->passwordHandler
            )
        );

        return $user->getId();
    }

    /**
     * challange(): defined by AuthenticatorInterface.
     *
     * @see    AuthenticatorInterface::challange()
     * @param  ResponseInterface $response
     * @return null|HttpResponse
     */
    public function challange(ResponseInterface $response)
    {
        if (!$response instanceof HttpResponse) {
            return null;
        }

        $response->getHeaders()->addHeaderLine('Location', $this->loginUrl);
        $response->setStatusCode(302);

        return $response;
    }

    /**
     * Sets the name of the identity field.
     *
     * @param  string $identityField
     * @return Doctrine
     */
    public function setIdentityField($identityField)
    {
        $this->identityField = $identityField;
        return $this;
    }

    /**
     * Sets the name of the password field.
     *
     * @param  string $passwordField
     * @return Doctrine
     */
    public function setPasswordField($passwordField)
    {
        $this->passwordField = $passwordField;
        return $this;
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
