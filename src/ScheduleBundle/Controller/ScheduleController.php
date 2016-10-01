<?php

namespace ScheduleBundle\Controller;

use BaseBundle\Entity\Day;
use ScheduleBundle\Entity\Schedule;
use ScheduleBundle\Form\ScheduleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package ScheduleBundle\Controller
 * @Route("/")
 */
class ScheduleController extends Controller
{
    /**
     * @Route("/", name="schedule_index")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/new", name="schedule_edit")
     * @Template()
     * @param Request $request
     * @param Day $day
     */
    public function newAction(Request $request)
    {
        $schedule = new Schedule();
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        }
        return [
            'form' => $form->createView(),
            'schedule' => $schedule
        ];
    }
}
