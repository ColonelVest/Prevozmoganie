<?php

namespace BaseBundle\Models;

use Monolog\Logger;

class ErrorMessageHandler
{
    /** @var  Logger $logger */
    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    const REQUESTED_DATA_NOT_EXISTS = 1;
    const INCORRECT_DATE_FORMAT = 2;
    const INCORRECT_TIME_FORMAT = 3;
    const INCORRECT_SCHEDULE_BEGIN_TIME = 4;

    public function getErrorMessageByCode($code)
    {
        if (self::$errors[$code]) {
            return self::$errors[$code];
        }
        $this->logger->error('Unexpected error');

        return self::$errors[0];
    }

    private static $errors = [
        0 => 'unexpected_error',
        1 => 'not_exist',
        2 => 'incorrect_date',
        3 => 'incorrect_time'
    ];
}