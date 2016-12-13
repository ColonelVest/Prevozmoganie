<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;
use TaskBundle\Form\PeriodType;
use FOS\RestBundle\View\View;

class PeriodController extends FOSRestController
{
    /**
     * @Rest\View()
     * @param Period $period
     * @return Period
     */
    public function getPeriodAction(Period $period)
    {
        return $period;
    }

    /**
     * @Rest\View()
     */
    public function getPeriodsAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('TaskBundle:Period')->findAll();
    }

    /**
     * @Rest\View()
     */
    public function postSchedulePeriodAction(Request $request, $dateString)
    {
        /** @var Schedule $schedule */
        $schedule = $this->container->get('schedule_service')->getSchedule($dateString);
        //TODO: Добавить проверку на наличие расписания
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
     */
    public function deleteSchedulePeriodAction($dateString, Period $period)
    {
        /** @var Schedule $schedule */
        $schedule = $this->container->get('schedule_service')->getSchedule($dateString);
        $em = $this->getDoctrine()->getManager();
        $schedule->removePeriod($period);
        $em->flush();

        return new View();
    }
}
