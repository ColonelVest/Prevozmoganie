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
        $expr = Criteria::expr();
        $criteria = (Criteria::create())->where($expr->eq('isBought', false));

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteBuyitemAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
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
     * @throws \BaseBundle\Lib\Serialization\NormalizationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
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