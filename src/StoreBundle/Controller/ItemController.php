<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Entity\Item;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function getItemAction($id)
    {
        return $this->getEntityResultById($id);
    }

    /**
    * @Rest\View
    * @return array
    */
    public function getItemsAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create(), false);
    }

    /**
    * @Rest\View
    * @param $id
    * @return array
    */
    public function deleteItemAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     */
    public function postItemsAction(Request $request)
    {
        return $this->createEntity(Item::class, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $id
     * @return array
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     * @throws \ReflectionException
     */
    public function putItemsAction(Request $request, $id)
    {
        return $this->editEntity($request, $id);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('item_handler');
    }
}