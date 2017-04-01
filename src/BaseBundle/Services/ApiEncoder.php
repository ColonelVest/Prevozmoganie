<?php

namespace BaseBundle\Services;

use BaseBundle\Models\Result;

class ApiEncoder
{
    public function encode($username, $password)
    {
        return Result::createSuccessResult($username . '|' . $password);
    }

    public function decode($token)
    {
        $delimiterPosition = strpos($token, '|');
        $username = substr($token, 0, $delimiterPosition);
        $password = substr($token, $delimiterPosition + 1);

        return Result::createSuccessResult([
            'username' => $username,
            'password' => $password
        ]);
    }
}