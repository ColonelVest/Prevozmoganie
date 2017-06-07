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

//    /**
//     * @Rest\View
//     * @param Request $request
//     * @return array
//     */
//    public function getTasksAction(Request $request)
//    {
//        $date = null;
//        if ($request->get('date')) {
//            $date = $this->getDateFromRequest($request, 'date');
//            if ($date === false) {
//                $result = Result::createErrorResult(ErrorMessages::PERIOD_DATE_INCORRECT);
//
//                return $this->getResponseByResultObj($result);
//            }
//        }
//        $expr = Criteria::expr();
//        $criteria = Criteria::create();
//        $criteria->where($expr->andX($expr->eq('date', $date), $expr->eq('isCompleted', false)));
//
//        return $this->getEntitiesByCriteria($criteria);
//    }

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
        return $this->generateWithEntries($request, 'tasks', true);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postRtasksAction(Request $request)
    {
        return $this->generateWithEntries($request, 'tasks');
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
