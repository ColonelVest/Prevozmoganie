<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Task;
use TaskBundle\Form\TaskType;

class TaskController extends FOSRestController
{
    /**
     * @param Task $task
     * @return mixed
     * @Rest\View()
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Task for a given id",
     *   output = "TaskBundle\Entity\Task",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     */
    public function getTaskAction(Task $task)
    {
        return $task;
    }

    /**
     * @Rest\View
     */
    public function getTasksAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('TaskBundle:Task')->findAll();
    }

    public function deleteTasksAction(Task $task)
    {
        $dm = $this->getDoctrine()->getManager();
        $dm->remove($task);
        $dm->flush();

        return new View();
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return Task
     */
    public function postTasksAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($task);
            $dm->flush();
        }

        return $task;
    }




}
