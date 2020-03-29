<?php

namespace BaseBundle\Services;

use BaseBundle\Models\ErrorMessages;
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
        if (is_null($token)) {
            return Result::createErrorResult(ErrorMessages::TOKEN_MISSING);
        }

        $result = $this->decode($token);
        if ($result->getIsSuccess()) {
            $userData = $result->getData();
            $result = $this->userHandler->getUser($userData['username']);

            if (!$result->getIsSuccess()) {
                return $result;
            }

            $result = $this->userHandler->checkUserPassword($result->getData(), $userData['password']);
        }

        return $result;
    }
}
