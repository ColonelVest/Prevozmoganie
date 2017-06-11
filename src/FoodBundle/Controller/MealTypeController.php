<?php

namespace FoodBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class MealTypeController extends BaseApiController
{
    /**
     * @Rest\View()
     * @return array
     */
    public function getMealtypesAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria( $criteria, false);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('food.services.meal_type_handler');
    }
}