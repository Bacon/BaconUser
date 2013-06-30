<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Repository;

use BaconUser\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionClass;

/**
 * @covers BaconUser\Repository\UserRepository
 */
class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectRepository;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->userRepository   = new UserRepository($this->objectRepository);
    }

    public function testFindOneByEmail()
    {
        $user = $this->getMock('BaconUser\Entity\UserInterface');

        $this
            ->objectRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(array('email' => 'test@example.org'))
            ->will($this->returnValue($user));

        $this->assertSame($user, $this->userRepository->findOneByEmail('test@example.org'));
    }

    /**
     * @dataProvider getProxiedMethods
     *
     * @param string $method
     * @param array $parameters
     */
    public function testProxiedMethodCalls($method, array $parameters)
    {
        $matcher = $this->objectRepository->expects($this->once())->method($method)->will($this->returnValue('foo'));

        //$matcher->parameterMatcher = new \PHPUnit_Framework_MockObject_Matcher_Parameters($parameters);

        $this->assertSame('foo', call_user_func_array(array($this->userRepository, $method), $parameters));
    }

    /**
     * @return array
     */
    public function getProxiedMethods()
    {
        $reflectionRepository = new ReflectionClass('Doctrine\Common\Persistence\ObjectRepository');
        $methods              = array();

        foreach ($reflectionRepository->getMethods() as $method) {
            $parameters = array();

            foreach ($method->getParameters() as $parameter) {
                $parameters[] = $parameter->isArray() ? array() : $parameter->getName();
            }

            $methods[] = array($method->getName(), $parameters);
        }

        return $methods;
    }
}
