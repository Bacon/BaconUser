<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Options\UserOptions;
use BaconUser\Service\UserService;
use DoctrineORMModuleTest\Util\ServiceManagerFactory;
use PHPUnit_Framework_TestCase as TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function setUp()
    {
        $sm = ServiceManagerFactory::getServiceManager();
        $sm->get('Doctrine\Common\DataFixtures\Executor\AbstractExecutor');

        $this->entityManager = $sm->get('BaconUser\EntityManager');

        $this->service = new UserService(
            $sm->get('BaconUser\Form\RegistrationForm'),
            $this->entityManager,
            new UserOptions()
        );
    }

    public function testRegister()
    {
        $result = $this->service->register(array(
            'username'              => 'foobar',
            'email'                 => 'foobar@example.com',
            'password'              => 'bazbat',
            'password_verification' => 'bazbat',
            'display_name'          => 'Foo Bar'
        ));

        $this->assertNotNull($result, 'Data validation failed');

        $user = $this->entityManager->getRepository('BaconUser\Entity\User')
                                    ->findOneBy(array('username' => 'foobar'));

        $this->assertInstanceOf('BaconUser\Entity\User', $user);
        $this->assertEquals('foobar', $user->getUsername());
        $this->assertEquals('foobar@example.com', $user->getEmail());
        $this->assertEquals('Foo Bar', $user->getDisplayName());
        $this->assertNotNull($user->getPasswordHash(), 'Password not set');
    }
}
