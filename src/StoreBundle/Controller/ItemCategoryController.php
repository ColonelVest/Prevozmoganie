<?php

namespace StoreBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use StoreBundle\Entity\ItemCategory;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ItemCategoryController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function getItemCategoryAction($id)
    {
        return $this->getEntityResultById($id);
    }

    /**
    * @Rest\View
    * @return array
    */
    public function getItemCategoriesAction()
    {
        return $this->getEntitiesByCriteria(Criteria::create());
    }

    /**
    * @Rest\View
    * @param $id
    * @return array
    */
    public function deleteItemCategoryAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @return array
    */
    public function postItemCategoriesAction(Request $request)
    {
        return $this->createEntity(ItemCategory::class, $request);
    }

    /**
    * @Rest\View
    * @param Request $request
    * @param $id
    * @return array
    */
    public function putItemCategoriesAction(Request $request, $id)
    {
        return $this->editEntity($request, $id);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('itemcategory_handler');
    }
}