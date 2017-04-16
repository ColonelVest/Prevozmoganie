<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityNormalizer;
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
     * @param Request $request
     * @param $ingredientId
     * @return array
     */
    public function getIngredientAction(Request $request, $ingredientId)
    {
        return $this->getEntityResultById($request, $ingredientId);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function getIngredientsAction(Request $request)
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($request, $criteria, false);
    }

    /**
     * @Rest\View
     * @param $id
     * @param Request $request
     * @return array
     */
    public function deleteIngredientAction($id, Request $request)
    {
        return $this->removeEntityById($id, $request);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postIngredientsAction(Request $request)
    {
        return $this->createEntity($request, Ingredient::class, IngredientType::class, false);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @param $ingredientId
     * @return array
     */
    public function putIngredientsAction(Request $request, $ingredientId)
    {
        return $this->editEntity($request, $ingredientId, IngredientType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.ingredient_handler');
    }

    protected function getNormalizer(): EntityNormalizer
    {
        return $this->get('food.services.ingredient_normalizer');
    }
}