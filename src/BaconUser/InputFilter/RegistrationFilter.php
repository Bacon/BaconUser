<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\InputFilter;

use BaconUser\Options\UserOptionsInterface;
use Zend\Validator\ValidatorInterface;

/**
 * Input filter for the {@see RegistrationForm}.
 */
class RegistrationFilter extends UserFilter
{
    /**
     * @param ValidatorInterface   $emailUniqueValidator
     * @param ValidatorInterface   $usernameUniqueValidator
     * @param UserOptionsInterface $options
     */
    public function __construct(
        ValidatorInterface   $emailUniqueValidator,
        ValidatorInterface   $usernameUniqueValidator,
        UserOptionsInterface $options
    ) {
        parent::__construct($options);

        $this->add(array(
            'name'       => 'password_verification',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));

        // Add specific validation rules
        $usernameValidators = $this->get('username')->getValidatorChain();
        $usernameValidators->attach($usernameUniqueValidator);

        $emailValidators = $this->get('email')->getValidatorChain();
        $emailValidators->attach($emailUniqueValidator);
    }
}
