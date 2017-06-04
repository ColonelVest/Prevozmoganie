<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FoodBundle\Entity\Ingredient;
use FoodBundle\Form\IngredientType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class IngredientController
 * @package FoodBundle\Controller
 */
class IngredientController extends BaseApiController
{
    /**
     * @Rest\View()
     * @param $ingredientId
     * @return array
     */
    public function getIngredientAction($ingredientId)
    {
        return $this->getEntityResultById($ingredientId);
    }

    /**
     * @Rest\View()
     * @return array
     */
    public function getIngredientsAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria, false);
    }

    /**
     * @Rest\View
     * @param $id
     * @return array
     */
    public function deleteIngredientAction($id)
    {
        return $this->removeEntityById($id);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postIngredientsAction(Request $request)
    {
        return $this->createEntity(Ingredient::class, $request);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @param $ingredientId
     * @return array
     */
    public function putIngredientsAction(Request $request, $ingredientId)
    {
        return $this->editEntity($request, $ingredientId);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.ingredient_handler');
    }
}