<?php

namespace TaskBundle\Controller;

use BaseBundle\Entity\Day;
use BaseBundle\Entity\DayRepository;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Entity\Schedule;
use TaskBundle\Entity\Task;
use TaskBundle\Form\ScheduleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package TaskBundle\Controller
 * @Route("/schedule")
 */
class ScheduleController extends Controller
{
    /**
     * @Route("/", name="schedule_index")
     * @Template()
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $task = new Task();
//        $task->setBody('taskBody first');
//        $task->setTitle('task1');
//        $em->persist($task);
//        $em->flush();
        return [];
    }

    /**
     * @Route("/{date}/new", name="schedule_new")
     * @Route("/new", name="schedule_new_current_day")
     * @Template()
     * @param Request $request
     * @param $date
     * @return array
     */
    public function newAction(Request $request, $date = null)
    {
        $schedule = new Schedule();
        $form = $this->createForm(ScheduleType::class, $schedule);
        $day = $this->getCurrentDay($date);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $day = $this->getCurrentDay($request);
        }
        return [
            'day' => $day,
            'form' => $form->createView(),
            'schedule' => $schedule
        ];
    }

    private function getCurrentDay($dateString)
    {
        $date = $this->get('datetime_handler')->getDateFromString($dateString);
        /** @var DayRepository $dayRepository */
        $dayRepository = $this->getDoctrine()->getRepository('BaseBundle:Day');
        return $dayRepository->fetchOrCreate($date, $this->getUser());
    }

    /**
     * @Route("/test")
     */
    public function testAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $repository = $dm->getRepository('TaskBundle:Task');

        return new Response();
    }

}
