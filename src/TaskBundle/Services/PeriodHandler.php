<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\User;
use BaseBundle\Models\ErrorMessageHandler;
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

    public function getPeriodById($periodId)
    {
        $period = $this->em->find('TaskBundle:Period', $periodId);
        if (is_null($period)) {
            return Result::createErrorResult([ErrorMessageHandler::REQUESTED_PERIOD_NOT_EXISTS]);
        }

        return Result::createSuccessResult($period);
    }

    public function getPeriods(\DateTime $date)
    {
        $periods = $this->em->getRepository('TaskBundle:Period')->findAll();

        return Result::createSuccessResult($periods);
    }

    public function createPeriod(?User $user, \DateTime $date, \DateTime $begin, \DateTime $end, $description)
    {
        $period = new Period();
        $period->setDescription($description);
        $period->setBegin($begin);
        $period->setEnd($end);
        $period->setDate($date);
        $period->setUser($user);

        return $this->validateEntityAndGetResult($period);
    }

    public function deletePeriod(Period $period)
    {
        $this->em->remove($period);
        $this->em->flush();

        return Result::createSuccessResult($period);
    }

    public function deletePeriodById($periodId)
    {
        $result = $this->getPeriodById($periodId);
        if ($result->getIsSuccess()) {

            return $this->deletePeriod($result->getData());
        }

        return $result;
    }
}