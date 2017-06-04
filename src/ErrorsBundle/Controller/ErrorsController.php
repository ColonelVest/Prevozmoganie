<?php

namespace ErrorsBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use ErrorsBundle\Entity\Error;
use ErrorsBundle\Form\ErrorType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ErrorsController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $errorId
     * @return array
     */
    public function getErrorAction($errorId)
    {
        return $this->getEntityResultById($errorId);
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getErrorsAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
     * @Rest\View
     * @param $errorId
     * @return array
     */
    public function deleteErrorAction($errorId)
    {
        return $this->removeEntityById($errorId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postErrorsAction(Request $request)
    {
        return $this->createEntity(Error::class, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $errorId
     * @return array
     */
    public function putErrorsAction(Request $request, $errorId)
    {
        return $this->editEntity($request, $errorId);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('errors_handler');
    }
}