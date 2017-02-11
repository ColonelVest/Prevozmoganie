<?php

namespace BaseBundle\Models;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class ErrorMessageHandler
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

    public function getErrorMessageByCode($code)
    {
        if (!isset(self::$errors[$code])) {
            $errorId = self::$errors[0];
        } else {
            //TODO: Добавить всякой информации
            $this->logger->error('Unexpected error');
            $errorId = self::$errors[$code];
        }

        return $this->translator->trans($errorId);
    }

    private static $errors = [
        0 => 'unexpected_error',
        1 => 'not_exists',
        2 => 'incorrect_date',
        3 => 'incorrect_time',
        4 => 'incorrect_schedule_begin_time',
        5 => 'period_not_exists'
    ];
}