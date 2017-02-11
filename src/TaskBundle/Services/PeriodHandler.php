<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessageHandler;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;

class PeriodHandler extends EntityHandler
{
    /** @var ScheduleHandler $scheduleHandler */
    private $scheduleHandler;

    public function __construct(
        EntityManager $em,
        ApiResponseFormatter $responseFormatter,
        RecursiveValidator $validator,
        ScheduleHandler $scheduleHandler
    ) {
        parent::__construct($em, $responseFormatter, $validator);
        $this->scheduleHandler = $scheduleHandler;
    }

    public function getPeriodById($periodId)
    {
        $period = $this->em->find('TaskBundle:Period', $periodId);
        if (is_null($period)) {
            return Result::createErrorResult([ErrorMessageHandler::REQUESTED_PERIOD_NOT_EXISTS]);
        }

        return Result::createSuccessResult($period);
    }

    public function getPeriods()
    {
        $periods = $this->em->getRepository('TaskBundle:Period')->findAll();

        return Result::createSuccessResult($periods);
    }

    public function createPeriod(Schedule $schedule, $begin, $end, $description)
    {
        $period = new Period();
        $period->setDescription($description);
        $beginTime = \DateTime::createFromFormat('H:i', $begin);
        $endTime = \DateTime::createFromFormat('H:i', $end);

        if (!($beginTime instanceof \DateTime) || !($endTime instanceof \DateTime)) {
            //TODO: Что делать с такой ситуацией? ПРи нормальной работе такого не должно быть
        }
        $period->setBegin($beginTime);
        $period->setEnd($endTime);
        $schedule->addPeriod($period);

        return $this->validateEntityAndGetResult($period);
    }

    public function deletePeriod(Period $period, Schedule $schedule)
    {
        $schedule->removePeriod($period);
        $this->em->flush();

        return Result::createSuccessResult($period);
    }

    public function deletePeriodById($periodId, $dateString)
    {
        $result = $this->getPeriodById($periodId);
        if ($result->getIsSuccess()) {
            $scheduleResult = $this->scheduleHandler->getScheduleByDateString($dateString);

            return $this->deletePeriod($result->getData(), $scheduleResult->getData());
        }

        return $result;
    }
}