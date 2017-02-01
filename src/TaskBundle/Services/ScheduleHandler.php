<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\User;
use BaseBundle\Models\ErrorMessageHandler;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use TaskBundle\Entity\Schedule;

/**
 * Действия с расписанием
 * Class Schedule
 * @package TaskBundle\Services
 */
class ScheduleHandler extends EntityHandler
{
    public function getScheduleByDateString($dateString): Result
    {
        $date = $this->getDateByString($dateString);
        if ($date === false) {
            return Result::createErrorResult(ErrorMessageHandler::INCORRECT_DATE_FORMAT);
        }

        $schedule = $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
        if (is_null($schedule)) {
            return Result::createErrorResult(ErrorMessageHandler::REQUESTED_DATA_NOT_EXISTS);

        }

        return Result::createSuccessResult($schedule);
    }

    public function getSchedules(): Result
    {
        $schedules = $this->em->getRepository('TaskBundle:Schedule')->findAll();

        return Result::createSuccessResult($schedules);
    }

    public function createSchedule($date, $beginTime, $description, ?User $user): Result
    {
        $date = $this->getDateByString($date);
        if ($date === false) {
            return Result::createErrorResult(ErrorMessageHandler::INCORRECT_DATE_FORMAT);
        }
        $startTime = $this->getDateByString($beginTime, 'H:i');
        if ($startTime === false) {
            return Result::createErrorResult(ErrorMessageHandler::INCORRECT_TIME_FORMAT);
        }

        $schedule = (new Schedule())
            ->setBeginTime($startTime)
            ->setDate($date)
            ->setDescription($description)
            ->setUser($user);

        return $this->validateEntityAndGetResult($schedule);
    }

    private function getDateByString($dateString, $format = 'dmY')
    {
        if (is_null($dateString)) {
            return new \DateTime();
        }

        return \DateTime::createFromFormat($format, $dateString);
    }
}