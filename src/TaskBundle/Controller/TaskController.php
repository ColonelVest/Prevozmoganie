<?php

namespace TaskBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations as Rest;

class TaskController extends FOSRestController
{
    /**
     * @param $id
     * @return mixed
     * @Rest\View()
     *  @ApiDoc(
     *   resource = true,
     *   description = "Gets a Task for a given id",
     *   output = "TaskBundle\Entity\Task",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     */
    public function getTaskAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('TaskBundle:Task')->find($id);
    }

    /**
     * @Rest\View
     */
    public function getTasksAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('TaskBundle:Task')->findAll();
    }


}
