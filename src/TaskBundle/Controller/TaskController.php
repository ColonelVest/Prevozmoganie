<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiNormalizer;
use BaseBundle\Services\EntityHandler;
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
        return $this->getEntities();
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
        $result = $this->fillEntityByRequest(new Task(), $request, TaskType::class);
        if ($result->getIsSuccess()) {
            $result = $this->get('task_handler')->create($result->getData());
            $result = $this->normalizeTaskByResult($result);
        }

        return $this->getResponseByResultObj($result);
    }


    public function putTaskAction(Request $request, $taskId)
    {
        $taskHandler = $this->get('task_handler');
        $result = $taskHandler->getById($taskId);
        if ($result->getIsSuccess()) {
            $result = $this->fillEntityByRequest($result->getData(), $request, TaskType::class);
            if ($result->getIsSuccess()) {
                $result = $taskHandler->edit($result->getData());
                $result = $this->normalizeTaskByResult($result);
            }
        }

        return $this->getResponseByResultObj($result);
    }

    private function normalizeTaskByResult(Result $result)
    {
        if (!is_null($result->getData())) {
            $normalizedPeriod = $this->get('api_normalizer')->conciseNormalizeTask($result->getData());
            $result->setData($normalizedPeriod);
        }

        return $result;
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
