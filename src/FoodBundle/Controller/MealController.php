<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use FoodBundle\Entity\Meal;
use FoodBundle\Form\MealForm;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class MealController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $mealId
     * @param Request $request
     * @return array
     */
    public function getMealAction($mealId, Request $request)
    {
        return $this->getEntityResultById($request, $mealId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function getMealsAction(Request $request)
    {
        $date = null;
        if ($request->get('date')) {
            $date = $this->getDateFromRequest($request, 'date');
            if ($date === false) {
                $result = Result::createErrorResult(ErrorMessages::MEALS_DATE_INCORRECT);

                return $this->getResponseByResultObj($result);
            }
        }

        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $criteria->where($expr->andX($expr->eq('date', $date)));

        return $this->getEntitiesByCriteria($request, $criteria);
    }

    /**
     * @Rest\View
     * @param $mealId
     * @param Request $request
     * @return array
     */
    public function deleteMealAction($mealId, Request $request)
    {
        return $this->removeEntityById($mealId, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postMealsAction(Request $request)
    {
        return $this->createEntity($request, Meal::class, MealForm::class, true);
    }

    public function postRMealsAction(Request $request)
    {

    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.meal_handler');
    }
}