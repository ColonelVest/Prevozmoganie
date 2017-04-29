<?php

namespace FoodBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class MealTypeHandler extends EntityHandler
{

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('FoodBundle:MealType');
    }
}