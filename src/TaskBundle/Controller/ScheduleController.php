<?php

namespace TaskBundle\Controller;

use BaseBundle\Models\Result;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Schedule;

class ScheduleController extends FOSRestController
{
    /**
     * @Rest\View()
     * @param null $dateString
     * @return array
     */
    public function getScheduleAction($dateString = null)
    {
        $result = $this->get('schedule_handler')->getSchedule($dateString);

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View
     */
    public function getSchedulesAction()
    {
        $result = $this->get('schedule_handler')->getSchedules();

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return Schedule
     */
    public function postScheduleAction(Request $request)
    {
        $dateString = $request->request->get('date');
        $startTimeString = $request->request->get('beginTime');
        $description = $request->request->get('description');
        $user = $this->getUser();
        $result = $this->get('schedule_handler')
            ->createSchedule($dateString, $startTimeString, $description, $user);

        return $this->getResponseByResultObj($result);
    }

    private function getResponseByResultObj(Result $result)
    {
        return $this->get('api_response_formatter')->createResponseFromResultObj($result);
    }

}