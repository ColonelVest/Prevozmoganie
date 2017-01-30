<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\Result;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;
use TaskBundle\Form\PeriodType;
use FOS\RestBundle\View\View;

class PeriodController extends BaseApiController
{
    /**
     * @Rest\View()
     * @param $periodId
     * @return Period
     */
    public function getPeriodAction($periodId = null)
    {
        $result = $this->get('task_handler')->getPeriodById($periodId);

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     */
    public function getPeriodsAction()
    {
        $result = $this->get('task_handler')->getPeriods();

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @ParamConverter("date", options={"format" : "dmY"})
     */
    public function postPeriodAction(Request $request, \DateTime $date)
    {
        $result = new Result();
        /** @var Schedule $schedule */
        $schedule = $this->container->get('schedule_service')->getSchedule($date);
        //TODO: Добавить проверку ¡£ªº“‘øπ˚«æ§Ú¯˘$period‹
        $period = new Period();
        //TODO: Создать трансформеры для этих данных
        //TODO: Проверку на корректность
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);
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

    /**
     * @Rest\View()
     * @ParamConverter("date", options={"format" : "dmY"})
     */
    public function deleteSchedulePeriodAction(\DateTime $date, Period $period)
    {
        /** @var Schedule $schedule */
        $schedule = $this->container->get('schedule_service')->getSchedule($date);
        $em = $this->getDoctrine()->getManager();
        $schedule->removePeriod($period);
        $em->flush();

        return new View();
    }
}
