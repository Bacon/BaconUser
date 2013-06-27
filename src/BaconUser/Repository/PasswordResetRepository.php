<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUser\Repository;

use BaconUser\Entity\PasswordResetRequest;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Password reset repository.
 */
class PasswordResetRepository implements PasswordResetRepositoryInterface
{
    /**
     * @var ObjectRepository
     */
    protected $passwordResetRepository;

    /**
     * @param ObjectRepository $passwordResetRepository
     */
    public function __construct(ObjectRepository $passwordResetRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * findOneByEmail(): defined by PasswordResetRepositoryInterface.
     *
     * @see    PasswordResetRepositoryInterface::findOneByEmail()
     * @param  string $email
     * @return PasswordResetRequest|null
     */
    public function findOneByEmail($email)
    {
        return $this->passwordResetRepository->findOneBy(array('email' => $email));
    }
}
