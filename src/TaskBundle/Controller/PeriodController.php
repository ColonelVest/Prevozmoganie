<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @ParamConverter("date", options={"format" : "dmY"})
     */
    public function postPeriodAction(Request $request, \DateTime $date)
    {
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
