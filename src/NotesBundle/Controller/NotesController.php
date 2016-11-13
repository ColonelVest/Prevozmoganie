<?php

namespace NotesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotesController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/test")
     */
    public function testAction()
    {
        $scheduleService = $this->container->get('schedule_service')->getSchedule('09112016');
        dump($scheduleService);exit();
    }
}
