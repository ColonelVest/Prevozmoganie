<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessageHandler;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;

class PeriodHandler extends EntityHandler
{
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

    public function createPeriod(Schedule $schedule, $duration, $description)
    {
        $period = new Period();
        $period->setDescription($description);
        $period->setDuration($duration);
        $schedule->addPeriod($period);

        return $this->validateEntityAndGetResult($period);
    }

    public function deletePeriod($periodId)
    {
        $periodResult = $this->getPeriodById($periodId);
        if ($periodResult->getIsSuccess()) {
            $this->em->remove($periodResult->getData());
            $this->em->flush();
        }

        return Result::createSuccessResult($periodResult->getData());
    }
}