<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Entity\BuyItem;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class BuyItemController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function getBuyitemAction($id)
    {
        return $this->getEntityResultById($id);
    }

    /**
    * @Rest\View
    * @return array
    */
    public function getBuyitemsAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
    * @Rest\View
    * @param $id
    * @return array
    */
    public function deleteBuyitemAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @return array
    */
    public function postBuyitemsAction(Request $request)
    {
        return $this->createEntity(BuyItem::class, $request);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @param $id
    * @return array
    */
    public function putBuyitemsAction(Request $request, $id)
    {
        return $this->editEntity($request, $id);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('buyitem_handler');
    }
}