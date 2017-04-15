<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Meal
 * @package FoodBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="meal")
 */
class Meal extends BaseEntity
{
    /**
     * @var MealType
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\MealType")
     */
    private $mealType;

    /**
     * @var Dish
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Dish")
     */
    private $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }

    /**
     * @return MealType
     */
    public function getMealType(): ?MealType
    {
        return $this->mealType;
    }

    /**
     * @param MealType $mealType
     * @return Meal
     */
    public function setMealType(MealType $mealType): Meal
    {
        $this->mealType = $mealType;

        return $this;
    }
}