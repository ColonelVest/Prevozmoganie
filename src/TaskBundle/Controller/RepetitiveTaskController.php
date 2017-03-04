<?php

namespace TaskBundle\Controller;


use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\AbstractNormalizer;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\RepetitiveTask;
use TaskBundle\Form\RepetitiveTaskType;

class RepetitiveTaskController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $taskId
     * @return array
     */
    public function getReptaskAction($taskId)
    {
        return $this->getEntityResultById($taskId);
    }

    /**
     * @Rest\View
     */
    public function getReptasksAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function deleteReptasksAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postReptasksAction(Request $request)
    {
        return $this->createEntity($request, RepetitiveTask::class, RepetitiveTaskType::class);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $taskId
     * @return array
     */
    public function putReptaskAction(Request $request, $taskId)
    {
        return $this->editEntity($request, $taskId, RepetitiveTaskType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('repetitive_task_handler');
    }

    protected function getNormalizer(): AbstractNormalizer
    {
        return $this->get('repetitive_task_normalizer');
    }
}