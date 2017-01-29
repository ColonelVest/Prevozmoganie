<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\User;
use BaseBundle\Models\ErrorsEnum;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use Doctrine\ORM\EntityManager;

/**
 * Действия с расписанием
 * Class Schedule
 * @package TaskBundle\Services
 */
class ScheduleHandler
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

    public function getSchedule($date) : Result
    {
        $result = new Result();
        $date = $this->getDateByString($date);
        if ($date === false) {
            return $result->addError(ErrorsEnum::INCORRECT_DATE_FORMAT)
                ->setIsSuccess(false);
        }

        $schedule = $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
        if (is_null($schedule)) {
            return $result
                ->addError(ErrorsEnum::REQUESTED_DATA_NOT_EXISTS)
                ->setIsSuccess(false);

        }

        return $result->setData($schedule);
    }

    public function createSchedule($date, $beginTime, User $user)
    {

    }

    private function getDateByString($dateString)
    {
        if (is_null($dateString)) {
            return new \DateTime();
        }

        return \DateTime::createFromFormat('dmY', $dateString);
    }
}