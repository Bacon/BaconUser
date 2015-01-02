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
use Zend\InputFilter\InputFilter;

/**
 * Base input filter for the {@see UserFieldset}.
 */
class UserFilter extends InputFilter
{
    /**
     * @param UserOptionsInterface $options
     */
    public function __construct(UserOptionsInterface $options)
    {
        if ($options->getEnableUsername()) {
            $this->add(array(
                'name'       => 'username',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 255,
                        ),
                    )
                ),
            ));
        }

        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                )
            ),
        ));

        $this->add(array(
            'name'       => 'password',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));
    }
}
