<?php

namespace NotesBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use NotesBundle\Entity\Listener;
use NotesBundle\Form\ListenerType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ListenerController extends BaseApiController
{
    /**
     * @Rest\View
     * @return array
     */
    public function getListenersAction(Request $request)
    {
//        $expr = Criteria::expr();
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($request, $criteria);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postListenerAction(Request $request)
    {
        return $this->createEntity($request, Listener::class, ListenerType::class);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $listenerId
     * @return array
     */
    public function putListenerAction(Request $request, $listenerId)
    {
        return $this->editEntity($request, $listenerId, ListenerType::class);
    }

    /**
     * @Rest\View
     * @param $listenerId
     * @param Request $request
     * @return array
     */
    public function deleteListenerAction($listenerId, Request $request)
    {
        return $this->removeEntityById($listenerId, $request);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('listeners_handler');
    }
}