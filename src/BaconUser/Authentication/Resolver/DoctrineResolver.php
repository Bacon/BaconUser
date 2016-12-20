<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Resolver;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Principal resolver for doctrine.
 */
class DoctrineResolver implements ResolverInterface
{
    /**
     * @var ObjectRepository
     */
    protected $userRepository;

    /**
     * @param ObjectRepository $userRepository
     */
    public function __construct(ObjectRepository     $userRepository)
    {
        $this->userRepository  = $userRepository;
    }

    /**
     * resolve(): defined by ResolverInterface.
     *
     * @see    ResolverInterface::resolve()
     * @param  int|float|string $identity
     * @return mixed
     */
    public function resolve($identity)
    {
        return $this->userRepository->find($identity);
    }
}
