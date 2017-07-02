<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Entity\ItemEntry;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ItemEntryController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function getItemEntryAction($id)
    {
        return $this->getEntityResultById($id);
    }

    /**
    * @Rest\View
    * @return array
    */
    public function getItemEntriesAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
    * @Rest\View
    * @param $id
    * @return array
    */
    public function deleteItemEntryAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @return array
    */
    public function postItemEntriesAction(Request $request)
    {
        return $this->createEntity(ItemEntry::class, $request);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @param $id
    * @return array
    */
    public function putItemEntriesAction(Request $request, $id)
    {
        return $this->editEntity($request, $id);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('itementry_handler');
    }
}