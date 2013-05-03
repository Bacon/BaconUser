<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Form;

use Zend\Form\FormInterface;

interface RegistrationFormInterface extends FormInterface
{
    public function __construct($name, UserOptions $options);
}
