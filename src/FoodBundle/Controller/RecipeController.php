<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityNormalizer;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FoodBundle\Entity\Recipe;
use FoodBundle\Form\RecipeType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class RecipeController extends BaseApiController
{
    /**
     * @Rest\View
     * @param Request $request
     * @param $recipeId
     * @return array
     */
    public function getRecipeAction(Request $request, $recipeId)
    {
        return $this->getEntityResultById($request, $recipeId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function getRecipesAction(Request $request)
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($request, $criteria, false);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postRecipesAction(Request $request)
    {
        return $this->createEntity($request, Recipe::class, RecipeType::class, false);
    }

    /**
     * @Rest\View()
     * @param Request $request
     * @param $recipeId
     * @return array
     */
    public function putRecipesAction(Request $request, $recipeId)
    {
        return $this->editEntity($request, $recipeId, RecipeType::class);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $recipeId
     * @return array
     */
    public function deleteDishesAction(Request $request, $recipeId)
    {
        return $this->removeEntityById($recipeId, $request);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.recipe_handler');
    }

    protected function getNormalizer(): EntityNormalizer
    {
        return $this->get('food.services.recipe_normalizer');
    }
}