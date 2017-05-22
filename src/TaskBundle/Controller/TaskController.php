<?php

namespace TaskBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Entity\DateCondition;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use TaskBundle\Entity\Task;
use TaskBundle\Form\TaskType;

class TaskController extends BaseApiController
{
    /**
     * @param Request $request
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
    public function getTaskAction(Request $request, $taskId)
    {
        return $this->getEntityResultById($request, $taskId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function getTasksAction(Request $request)
    {
        $date = null;
        if ($request->get('date')) {
            $date = $this->getDateFromRequest($request, 'date');
            if ($date === false) {
                $result = Result::createErrorResult(ErrorMessages::PERIOD_DATE_INCORRECT);

                return $this->getResponseByResultObj($result);
            }
        }
//        KernelEvents::CONTROLLER
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $criteria->where($expr->andX($expr->eq('date', $date), $expr->eq('isCompleted', false)));

        return $this->getEntitiesByCriteria($request, $criteria);
    }

    /**
     * @Rest\View
     * @param $id
     * @param Request $request
     * @return array
     */
    public function deleteTaskAction($id, Request $request)
    {
        return $this->removeEntityById($id, $request);
    }

//    /**
//     * @Rest\View
//     * @param Request $request
//     * @return Task
//     */
//    public function postTasksAction(Request $request)
//    {
//        return $this->createEntity($request, Task::class, 'task');
//    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postRtasksAction(Request $request)
    {
        $result = $this->fillEntityByRequest(new Task(), $request, 'task', true);
        if ($result->getIsSuccess()) {
            $task = $result->getData();
            $this->getUser();
            $result = $this->get('task_handler')->generateRepetitiveTasks($result->getData());
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
        return $this->editEntity($request, $taskId, TaskType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('task_handler');
    }
}
