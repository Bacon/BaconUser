<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconStringUtils For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Service;

use BaconUser\Service\UserService;
use DoctrineORMModuleTest\Util\ServiceManagerFactory;
use PHPUnit_Framework_TestCase as TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    protected $service;

    public function setUp()
    {
        $sm = ServiceManagerFactory::getServiceManager();
        $this->service = new UserService();
        $this->service->setServiceManager($sm);
        $sm->get('Doctrine\Common\DataFixtures\Executor\AbstractExecutor');
    }

    public function testRegister()
    {
        $this->service->register(array());

        var_dump($this->service->getEntityManager()->find('BaconUser\Entity\User', '1'));
    }
}
