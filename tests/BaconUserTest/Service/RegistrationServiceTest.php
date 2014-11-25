<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Entity\User;
use BaconUser\Options\UserOptions;
use BaconUser\Service\RegistrationEvent;
use BaconUser\Service\RegistrationService;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Service\RegistrationService
 */
class RegistrationServiceTest extends TestCase
{
    public function testEntityIsBoundToForm()
    {
        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('bind')
             ->with($this->isInstanceOf('BaconUser\Entity\UserInterface'));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $service = new RegistrationService($form, $objectManager, new UserOptions());
        $service->register(array());
    }

    public function testDataArePassedToForm()
    {
        $data = array(
            'username' => 'foobar',
            'email'    => 'foobar@example.com',
        );

        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($this->equalTo($data));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $service = new RegistrationService($form, $objectManager, new UserOptions());
        $service->register($data);
    }

    public function testValidRegistration()
    {
        $user = new User();

        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('isValid')
             ->will($this->returnValue(true));
        $form->expects($this->once())
             ->method('getData')
             ->will($this->returnValue($user));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->expects($this->once())
                      ->method('persist')
                      ->with($this->equalTo($user));
        $objectManager->expects($this->once())
                      ->method('flush');

        $service = new RegistrationService($form, $objectManager, new UserOptions());

        // Event should be triggered
        $callback     = $this->getMock('stdLib', array('__invoke'));
        $eventManager = $service->getEventManager();

        $callback->expects($this->once())->method('__invoke');
        $eventManager->attach(RegistrationEvent::EVENT_USER_REGISTERED, $callback);

        $result  = $service->register(array());
        $this->assertSame($user, $result);
    }

    public function testInvalidRegistration()
    {
        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('isValid')
             ->will($this->returnValue(false));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->expects($this->never())
                      ->method('persist');
        $objectManager->expects($this->never())
                      ->method('flush');

        $service = new RegistrationService($form, $objectManager, new UserOptions());

        // Event should not be triggered if registration is invalid
        $callback     = $this->getMock('stdLib', array('__invoke'));
        $eventManager = $service->getEventManager();

        $callback->expects($this->never())->method('__invoke');
        $eventManager->attach(RegistrationEvent::EVENT_USER_REGISTERED, $callback);

        $result  = $service->register(array());
        $this->assertNull($result);
    }

    public function testInvalidReturnedDataTriggersException()
    {
        $this->setExpectedException(
            'BaconUser\Exception\UnexpectedValueException',
            'array does not implement BaconUser\Entity\UserInterface'
        );

        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('isValid')
             ->will($this->returnValue(true));
        $form->expects($this->once())
             ->method('getData')
             ->will($this->returnValue(array()));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->expects($this->never())
                      ->method('persist');
        $objectManager->expects($this->never())
                      ->method('flush');

        $service = new RegistrationService($form, $objectManager, new UserOptions());
        $service->register(array());
    }

    public function testStateIsSetWhenEnabled()
    {
        $user = new User();

        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('isValid')
             ->will($this->returnValue(true));
        $form->expects($this->once())
             ->method('getData')
             ->will($this->returnValue($user));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => true, 'default_user_state' => 2));
        $service = new RegistrationService($form, $objectManager, $options);
        $result  = $service->register(array());
        $this->assertSame($user, $result);
        $this->assertEquals(2, $result->getState());
    }

    public function testStateIsNotSetWhenDisabled()
    {
        $user = new User();

        $form = $this->getMock('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('isValid')
             ->will($this->returnValue(true));
        $form->expects($this->once())
             ->method('getData')
             ->will($this->returnValue($user));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $options = new UserOptions(array('enable_user_state' => false, 'default_user_state' => 2));
        $service = new RegistrationService($form, $objectManager, $options);
        $result  = $service->register(array());
        $this->assertSame($user, $result);
        $this->assertNull($result->getState());
    }
}
