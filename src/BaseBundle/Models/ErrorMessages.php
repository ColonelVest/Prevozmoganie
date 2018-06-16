<?php

namespace BaseBundle\Models;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class ErrorMessages
{
    /** @var  Logger $logger */
    private $logger;
    /** @var  Translator */
    private $translator;

    public function __construct(Logger $logger, Translator $translator) {
        $this->logger = $logger;
        $this->translator = $translator;
    }

    const REQUESTED_DATA_NOT_EXISTS = 1;
    const INCORRECT_DATE_FORMAT = 2;
    const INCORRECT_TIME_FORMAT = 3;
    const INCORRECT_SCHEDULE_BEGIN_TIME = 4;
    const REQUESTED_PERIOD_NOT_EXISTS = 5;
    const PERIOD_DATE_INCORRECT = 6;
    const REQUESTED_TASK_NOT_EXISTS = 7;
    const REQUESTED_ERROR_NOT_EXISTS = 8;
    const UNKNOWN_USERNAME = 9;
    const INCORRECT_PASSWORD = 10;
    const INCORRECT_TOKEN = 11;
    const NOT_AUTHORIZED = 12;
    const PERMISSION_DENIED = 13;
    const MEALS_DATE_INCORRECT = 14;
    const TOKEN_MISSING = 15;
    const MANDATORY_PARAM_IS_MISSING = 16;
    const FNS_HTTPS_FAIL = 17;

    public function getErrorMessageByCode($code, $params = [])
    {
        if (!isset(self::$errorMessagesTransIds[$code])) {
            $errorId = self::$errorMessagesTransIds[0];
        } else {
            //TODO: Добавить всякой информации
            $this->logger->error('Unexpected error');
            $errorId = self::$errorMessagesTransIds[$code];
        }

        return $this->translator->trans($errorId, $params);
    }

    private static $errorMessagesTransIds = [
        0 => 'unexpected_error',
        1 => 'not_exists',
        2 => 'incorrect_date',
        3 => 'incorrect_time',
        4 => 'incorrect_schedule_begin_time',
        5 => 'period_not_exists',
        6 => 'period_date_incorrect',
        7 => 'requested_task_not_exists',
        8 => 'requested_error_not_exists',
        9 => 'unknown_username',
        10 => 'incorrect_password',
        11 => 'incorrect_token',
        12 => 'not_authorized',
        13 => 'permission_denied',
        14 => 'meals_date_incorrect',
        15 => 'token_missing',
        16 => 'mandatory_param_is_missing',
        17 => 'fns_request_fail'
    ];
}