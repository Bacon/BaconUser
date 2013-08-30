<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form;

use BaconUser\Options\UserOptionsInterface;
use Zend\Form\Form;

/**
 * Generic registration form.
 */
class RegistrationForm extends Form
{
    public function __construct(UserOptionsInterface $options)
    {
        parent::__construct(null);

        if ($options->getEnableUsername()) {
            $this->add(array(
                'name' => 'username',
                'options' => array(
                    'label' => 'Username',
                ),
                'attributes' => array(
                    'type' => 'text',
                ),
            ));
        }

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'password_verification',
            'options' => array(
                'label' => 'Verify password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'options' => array(
                'label' => 'Register',
            ),
            'attributes' => array(
                'type' => 'submit',
            ),
        ), array(
            'priority' => -100
        ));
    }
}
