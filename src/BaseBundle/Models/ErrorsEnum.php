<?php

namespace BaseBundle\Models;


class ErrorsEnum
{
    const REQUESTED_DATA_NOT_EXISTS = 1;
    const INCORRECT_DATE_FORMAT = 2;

    public static function getErrorMessageByCode($code)
    {
        if (self::$errors[$code]) {
            return self::$errors[$code];
        }

        return self::$errors[0];
    }

    private static $errors = [
        0 => 'unexpected_error',
        1 => 'not_exist',
        2 => 'incorrect_date'
    ];
}