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
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Validator\ValidatorInterface;

/**
 * Input filter for the {@see RegistrationForm}.
 */
class RegistrationFilter extends UserFilter
{
    /**
     * @param ObjectRepository   $objectRepository
     * @param ValidatorInterface $usernameValidator
     * @param ValidatorInterface $emailValidator
     * @param UserOptionsInterface $options
     */
    public function __construct(
        ObjectRepository $objectRepository,
        ValidatorInterface $usernameValidator,
        ValidatorInterface $emailValidator,
        UserOptionsInterface $options
    ) {
        parent::__construct($options);

        if ($options->getEnableUsername()) {
            $usernameInput = $this->get('username');
            $usernameInput->getValidatorChain()->attach($usernameValidator);
        }

        $emailInput = $this->get('email');
        $emailInput->getValidatorChain()->attach($emailValidator);

        $this->add(array(
            'name'       => 'passwordVerification',
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
    }
}
