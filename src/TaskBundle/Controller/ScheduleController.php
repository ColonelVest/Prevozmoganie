<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Schedule;
use TaskBundle\Entity\ScheduleRepository;
use TaskBundle\Form\ScheduleType;

class ScheduleController extends FOSRestController {
    /**
     * @Rest\View()
     * @param $dateString
     * @return Schedule
     */
    public function getScheduleAction($dateString)
    {
        //TODO: Добавить проверку на корректность данных
        $date = \DateTime::createFromFormat('dmY', $dateString);
        /** @var ScheduleRepository $scheduleRepository */
        $scheduleRepository = $this->getDoctrine()->getRepository('TaskBundle:Schedule');

        return $scheduleRepository->fetchOrCreate($date, $this->getUser());
    }

    /**
     * @Rest\View
     */
    public function getSchedulesAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('TaskBundle:Schedule')->findAll();
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return Schedule
     */
    public function postScheduleAction(Request $request)
    {
        $schedule = new Schedule();
        //TODO: Создать трансформеры для этих данных
        //TODO: Проверку на корректность
        $date = \DateTime::createFromFormat('dmY', $request->request->get('date'));
        $startTime = \DateTime::createFromFormat('H:i', $request->request->get('beginTime'));
        $schedule
            ->setBeginTime($startTime)
            ->setDate($date);
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($schedule);
            $dm->flush();
        } else {
            $asda = $form->getErrors(true);
            $sdfasdf = '';
        }

        return $schedule;
    }

}