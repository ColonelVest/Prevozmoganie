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

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Period');
    }
}