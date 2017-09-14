<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Entity\DateCondition;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Task;

class TaskController extends BaseApiController
{
    /**
     * @param $taskId
     * @return array
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
    public function getTaskAction($taskId)
    {
        return $this->getEntityResultById($taskId);
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getTasksAction()
    {
        $criteria = Criteria::create();
        $expression = Criteria::expr();
        $criteria->where($expression->eq('type', Task::RECURRING_TYPE));

        return $this->getEntitiesByCriteria($criteria, true);
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
     * @return array
     */
    public function postTasksAction(Request $request)
    {
        return $this->generateWithEntries($request, 'task', true);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postRtasksAction(Request $request)
    {
        return $this->generateWithEntries($request, 'task');
    }

    /**
     * @Rest\View
     * @Rest\Post("tasks_line_lengths")
     * @param Request $request
     * @return array
     */
    public function getTasksStatisticAction(Request $request)
    {
        $requestedTasksIds = $request->request->get('tasksIds');

        return ['data' => $request->request->get('tasksIds')];
    }

    /**
     * @param Request $request
     * @param $name
     * @param bool $returnSingle
     * @return array
     */
    private function generateWithEntries(Request $request, $name, $returnSingle = false)
    {
        $tasksData = $request->request->get($name);
        $result = $this->fillEntityByRequestData(new Task(), $tasksData['entity']);
        if ($result->getIsSuccess()) {
            /** @var Task $task */
            $task = $result->getData();
            $task->setType(Task::RECURRING_TYPE);
            $result = $this->fillEntityByRequestData(new DateCondition(), $tasksData['condition']);
            if ($result->getIsSuccess()) {
                $result = $this->get('task_handler')
                    ->generateRepetitiveTasks($result->getData(), $task, $this->getUser(), $returnSingle);
            }
        }

        return $this->getResponseByResultObj($result);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $taskId
     * @return array
     */
    public function putTaskAction(Request $request, $taskId)
    {
        return $this->editEntity($request, $taskId);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('task_handler');
    }
}
