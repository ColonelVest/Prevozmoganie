<?php

namespace UserBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\UserTokenHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use UserBundle\Entity\User;

class UserHandler
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  UserPasswordEncoder $encoder */
    private $passwordEncoder;

    public function __construct(EntityManager $em, UserPasswordEncoder $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('UserBundle:User');
    }

    /**
     * @param $username
     *
     * @return Result|User
     */
    public function getUser($username)
    {
        /** @var User $user */
        $user = $this->getRepository()->findOneBy(['username' => $username]);
        if (is_null($user)) {
            return Result::createErrorResult(ErrorMessages::UNKNOWN_USERNAME);
        }

        return Result::createSuccessResult($user);
    }

    /**
     * @param User   $user
     * @param string $password
     * @param bool   $isPlainPassword
     *
     * @return Result
     */
    public function checkUserPassword(User $user, string $password, $isPlainPassword = false)
    {
        if (($isPlainPassword && $this->passwordEncoder->isPasswordValid($user, $password))
            || (!$isPlainPassword && $user->getPassword() == $password)
        ) {
            return Result::createSuccessResult($user);
        }

        return Result::createErrorResult(ErrorMessages::INCORRECT_PASSWORD);
    }
}
