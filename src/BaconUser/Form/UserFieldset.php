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
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Base fieldset for user
 */
class UserFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param HydratorInterface    $hydrator
     * @param UserOptionsInterface $options
     */
    public function __construct(HydratorInterface $hydrator, UserOptionsInterface $options)
    {
        parent::__construct('user');
        $this->setHydrator($hydrator);

        if ($options->getEnableUsername()) {
            $this->add(array(
                'name' => 'username',
                'options' => array(
                    'label' => 'Username',
                ),
                'attributes' => array(
                    'required' => 'required',
                ),
            ));
        }

        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));
    }
}
