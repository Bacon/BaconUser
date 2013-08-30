<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form\User;

use BaconUser\Options\UserOptionsInterface;
use Zend\Form\Form;

/**
 * Generic registration form.
 */
class RegistrationForm extends Form
{
    public function __construct()
    {
        parent::__construct('registration-form');

        $this->add(array(
            'type'    => 'BaconUser\Form\UserFieldset',
            'name'    => 'user',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

        $this->add(array(
            'type' => 'Csrf',
            'name' => 'csrf'
        ));

        $this->add(array(
            'type'    => 'Submit',
            'name'    => 'submit',
            'options' => array(
                'label' => 'Register',
            )
        ));

        // Add specific registration elements

        $userFieldset = $this->get('user');
        $userFieldset->add(array(
            'type'    => 'Password',
            'name'    => 'passwordVerification',
            'options' => array(
                'label' => 'Verify password'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));
    }
}
