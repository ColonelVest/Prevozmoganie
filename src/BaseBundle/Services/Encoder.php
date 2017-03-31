<?php

namespace BaseBundle\Services;


class Encoder
{
    public function encode($username, $password)
    {
        return $username . '|' . $password;
    }

    public function decode($token)
    {
        $delimiterPosition = strpos($token, '|');
        $username = substr($token, 0, $delimiterPosition);
        $password = substr($token, $delimiterPosition + 1);

        return [
            'username' => $username,
            'password' => $password
        ];
    }
}