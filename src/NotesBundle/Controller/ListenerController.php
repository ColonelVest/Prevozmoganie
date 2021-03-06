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
    public function getListenersAction()
    {
//        $expr = Criteria::expr();
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @Rest\View()
     * @param $listenerId
     * @return array
     */
    public function getListenerAction($listenerId)
    {
        return $this->getEntityResultById($listenerId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postListenerAction(Request $request)
    {
        return $this->createEntity( Listener::class, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $listenerId
     * @return array
     */
    public function putListenerAction(Request $request, $listenerId)
    {
        return $this->editEntity($request, $listenerId);
    }

    /**
     * @Rest\View
     * @param $listenerId
     * @return array
     */
    public function deleteListenerAction($listenerId)
    {
        return $this->removeEntityById($listenerId);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('listeners_handler');
    }
}