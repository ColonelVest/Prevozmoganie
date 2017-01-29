<?php

namespace TaskBundle\Services;
use BaseBundle\Services\ApiResponseFormatter;

/**
 * Обработка запросов API расписаний
 * Class ScheduleApiRequestHandler
 * @package TaskBundle\Services
 */
class ScheduleApiRequestHandler
{
    /** @var  ApiResponseFormatter */
    private $responseFormatter;
    /** @var  ScheduleHandler $handler */
    private $handler;

    public function __construct(ApiResponseFormatter $responseFormatter, ScheduleHandler $handler) {
        $this->responseFormatter = $responseFormatter;
        $this->handler = $handler;
    }

    public function getSchedule($dateString)
    {
        $result = $this->handler->getSchedule($dateString);

        return $this->responseFormatter->createResponseFromResultObj($result);
    }

}