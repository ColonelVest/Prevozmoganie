<?php

namespace TaskBundle\Services;

use BaseBundle\Services\ApiResponseFormatter;
use Doctrine\ORM\EntityManager;

class Schedule
{
    /** @var  EntityManager $em */
    private $em;

    /** @var  ApiResponseFormatter $responseFormatter */
    private $responseFormatter;

    public function __construct(EntityManager $em, ApiResponseFormatter $responseFormatter)
    {
        $this->em = $em;
        $this->responseFormatter = $responseFormatter;
    }

    public function getSchedule($dateString)
    {
        $date = $this->getDateByString($dateString);

        return $schedule = $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
    }

    public function getScheduleResponse($date)
    {
        $date = $this->getDateByString($date);
        if ($date === false) {
            return $this->responseFormatter->createErrorResponse()
                ->addResponseMessage(ApiResponseFormatter::INCORRECT_DATE_FORMAT)
                ->getResponse();
        }

        $schedule = $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
        if (is_null($schedule)) {
            return $this->responseFormatter->getDataNotExistsResponse();
        }

        return $this->responseFormatter
            ->createSuccessResponse()
            ->addResponseData($schedule, 'schedule')
            ->getResponse();
    }

    private function getDateByString($dateString)
    {
        if (is_null($dateString)) {
            return new \DateTime();
        }

        return \DateTime::createFromFormat('dmY', $dateString);
    }
}