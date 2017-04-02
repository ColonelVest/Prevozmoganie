<?php

namespace BaseBundle\Services;

use BaseBundle\Models\Result;
use UserBundle\Services\UserHandler;

class UserTokenHandler
{
    /** @var UserHandler $userHandler */
    private $userHandler;

    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }

    public function encode($username, $password)
    {
        return Result::createSuccessResult($username . '|' . $password);
    }

    private function decode($token)
    {
        $delimiterPosition = strpos($token, '|');
        $username = substr($token, 0, $delimiterPosition);
        $password = substr($token, $delimiterPosition + 1);

        //TODO: Проверить кривые ситуации
        return Result::createSuccessResult([
            'username' => $username,
            'password' => $password
        ]);
    }

    public function isTokenCorrect($token)
    {
        return $this->getUserByToken($token);

    }
    
    public function getUserByToken($token)
    {
        $result = $this->decode($token);
        if ($result->getIsSuccess()) {
            $userData = $result->getData();
            $result = $this->userHandler->getUser($userData['username'], $userData['password']);
        }

        return $result;
    }
}