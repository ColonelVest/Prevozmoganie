<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\Period;
use UserBundle\Entity\User;

class PeriodHandler extends EntityHandler
{
    protected $notExistsMessage = ErrorMessages::REQUESTED_PERIOD_NOT_EXISTS;

    public function getPeriodById($periodId) : Result
    {
        return $this->getById($periodId);
    }

    public function getPeriods(\DateTime $date) : Result
    {
        $periods = $this->em->getRepository('TaskBundle:Period')->getByDate($date);

        return Result::createSuccessResult($periods);
    }

    public function createPeriod(Period $period) : Result
    {
        return $this->create($period);
    }

    public function deletePeriod(Period $period)
    {
        return $this->remove($period);
    }

    public function editPeriod(Period $period) : Result
    {
        return $this->edit($period);
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Period');
    }
}