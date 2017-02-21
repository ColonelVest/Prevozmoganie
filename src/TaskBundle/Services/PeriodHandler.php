<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\Period;

class PeriodHandler extends EntityHandler
{
    public function __construct(
        EntityManager $em,
        ApiResponseFormatter $responseFormatter,
        RecursiveValidator $validator
    ) {
        parent::__construct($em, $responseFormatter, $validator);
    }

    public function getPeriodById($periodId) : Result
    {
        $period = $this->em->find('TaskBundle:Period', $periodId);
        if (is_null($period)) {
            return Result::createErrorResult([ErrorMessages::REQUESTED_PERIOD_NOT_EXISTS]);
        }

        return Result::createSuccessResult($period);
    }

    public function getPeriods(\DateTime $date) : Result
    {
        $periods = $this->em->getRepository('TaskBundle:Period')->getByDate($date);

        return Result::createSuccessResult($periods);
    }

    public function createPeriod(Period $period) : Result
    {
        return $this->validateEntityAndGetResult($period);
    }

    public function deletePeriod(Period $period)
    {
        $periodId = $period->getId();
        $this->em->remove($period);
        $this->em->flush();

        return Result::createSuccessResult($periodId);
    }

    public function deletePeriodById($periodId) : Result
    {
        $result = $this->getPeriodById($periodId);
        if ($result->getIsSuccess()) {
            return $this->deletePeriod($result->getData());
        }

        return $result;
    }

    public function editPeriod(Period $period) : Result
    {
        return $this->validateEntityAndGetResult($period);
    }
}