<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiNormalizer;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Task;
use TaskBundle\Form\TaskType;

class TaskController extends BaseApiController
{
    /**
     * @param $taskId
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
     * @return array
     */
    public function getTaskAction($taskId)
    {
        return $this->getEntityResultById($taskId);
    }

    /**
     * @Rest\View
     */
    public function getTasksAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function deleteTaskAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return Task
     */
    public function postTasksAction(Request $request)
    {
        return $this->createEntity($request, Task::class, TaskType::class);
    }


    public function putTaskAction(Request $request, $taskId)
    {
        return $this->editEntity($request, $taskId, TaskType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('task_handler');
    }

    protected function getNormalizer() : ApiNormalizer
    {
        return $this->get('task_normalizer');
    }
}
