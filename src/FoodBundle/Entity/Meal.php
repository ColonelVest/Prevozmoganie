<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
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
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isPerformed = false;

    /**
     * @var Dish
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Dish")
     */
    //TODO: Сменить на множ
    private $dish;

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

    /**
     * @return bool
     */
    public function isIsPerformed(): ?bool
    {
        return $this->isPerformed;
    }

    /**
     * @param bool $isPerformed
     * @return Meal
     */
    public function setIsPerformed(bool $isPerformed): Meal
    {
        $this->isPerformed = $isPerformed;

        return $this;
    }

    /**
     * @return Dish
     */
    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    /**
     * @param Dish $dish
     * @return Meal
     */
    public function setDish(Dish $dish): Meal
    {
        $this->dish = $dish;

        return $this;
    }
}