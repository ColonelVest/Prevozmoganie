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
    /** @var  UserTokenHandler $apiEncoder */
    private $apiEncoder;

    public function __construct(EntityManager $em, UserPasswordEncoder $passwordEncoder, UserTokenHandler $apiEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->apiEncoder = $apiEncoder;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('UserBundle:User');
    }

    public function getUser($username, $password)
    {
        /** @var User $user */
        $user = $this->getRepository()->findOneBy(['username' => $username]);
        if (is_null($user)) {
            return Result::createErrorResult(ErrorMessages::UNKNOWN_USERNAME);
        }

        if ($user->getPassword() == $this->passwordEncoder->isPasswordValid($user, $password)) {
            return Result::createSuccessResult($user);
        }

        return Result::createErrorResult(ErrorMessages::INCORRECT_PASSWORD);
    }

    public function getToken($username, $password)
    {
        $userResult = $this->getUser($username, $password);
        if (!$userResult->getIsSuccess()) {
            return $userResult;
        }

        return Result::createSuccessResult($this->apiEncoder->encode($username, $userResult->getData()->getPassword()));
    }
}