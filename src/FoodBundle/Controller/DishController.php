<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FoodBundle\Entity\Dish;
use FoodBundle\Form\DishType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class DishController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $dishId
     * @return array
     */
    public function getDishAction($dishId)
    {
        return $this->getEntityResultById($dishId);
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getDishesAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria, false);
    }

    /**
     * @Rest\View
     * @param $dishId
     * @return array
     */
    public function deleteDishesAction($dishId)
    {
        return $this->removeEntityById($dishId);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postDishAction(Request $request)
    {
        return $this->createEntity($request, Dish::class, DishType::class, false);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $dishId
     * @return array
     */
    public function putDishesAction(Request $request, $dishId)
    {
        return $this->editEntity($request, $dishId, DishType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.dish_handler');
    }
}