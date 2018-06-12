<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Entity\Item;
use FOS\RestBundle\Controller\Annotations as Rest;
use StoreBundle\Services\ItemHandler;
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
     * @Rest\Get("supersede_item")
     * @param Request $request
     * @return \BaseBundle\Models\Result
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function supersedeItemAction(Request $request)
    {
        $supersedeItem = $this->getHandler()->getById($request->query->get('supersedeItemId'));
        if (!$supersedeItem->getIsSuccess()) {
            return $supersedeItem;
        }

        $item = $this->getHandler()->getById($request->query->get('itemId'));
        if (!$item->getIsSuccess()) {
            return $item;
        }

        return $this->getHandler()->supersedeItem($supersedeItem->getData(), $item->getData());
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

    /**
     * @return ItemHandler
     */
    protected function getHandler(): EntityHandler
    {
        return $this->get('item_handler');
    }
}