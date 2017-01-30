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

class TaskHandler extends EntityHandler
{
    /** @var  ScheduleHandler $scheduleHandler */
    private $scheduleHandler;

    public function __construct(EntityManager $em, ApiResponseFormatter $responseFormatter, RecursiveValidator $validator, ScheduleHandler $scheduleHandler)
    {
        parent::__construct($em, $responseFormatter, $validator);
        $this->scheduleHandler = $scheduleHandler;
    }

    public function getPeriodById($periodId)
    {
        $result = new Result();
        $period = $this->em->find('TaskBundle:Period', $periodId);
        if (is_null($period)) {
            return $result->setIsSuccess(false)->addError(ErrorMessageHandler::PERIOD_ID_NOT_EXISTS);
        }

        return $result->setData($period);
    }

    public function getPeriods()
    {
        $result = new Result();
        $periods = $this->em->getRepository('TaskBundle:Period')->findAll();

        return $result->setData($periods);
    }

    public function createPeriod($dateString)
    {
        $result = new Result();

        $period = new Period();
        if ($form->isValid()) {
            $schedule->addPeriod($period);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($period);
            $dm->flush();
        } else {
            $asda = $form->getErrors(true);
            $sdfasdf = '';
        }

        return $period;
    }
}