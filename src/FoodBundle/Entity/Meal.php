<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as Serializer;
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
     * @var string
     * @ORM\Column(type="string")
     * @Serializer\Groups({"full", "concise", "nested"})
     */
    private $title;

    /**
     * @var MealType
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\MealType")
     * @Serializer\Groups({"full", "concise", "nested"})
     */
    private $mealType;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="FoodBundle\Entity\Dish")
     * @ORM\JoinTable(name="meal_dishes",
     *      joinColumns={@ORM\JoinColumn(name="meal_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="dish_id", referencedColumnName="id")}
     *      )
     * @Serializer\Groups({"full", "concise", "nested"})
     */
    private $dishes;

    /**
     * @var MealEntry[]
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\MealEntry", mappedBy="meal", cascade={"persist", "remove"})
     * @Serializer\Groups({"full"})
     */
    private $mealEntries;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
        $this->mealEntries = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|MealEntry[]
     */
    public function getMealEntries()
    {
        return $this->mealEntries;
    }

    /**
     * @return ArrayCollection
     */
    public function getDishes()
    {
        return $this->dishes;
    }

    /**
     * @param Dish $dish
     * @return Meal
     */
    public function addDish(Dish $dish)
    {
        $this->dishes->add($dish);

        return $this;
    }

    /**
     * @param Dish $dish
     * @return Meal
     */
    public function removeDish(Dish $dish)
    {
        $this->dishes->remove($dish);

        return $this;
    }

    /**
     * @return Meal
     */
    public function removeAllDishes()
    {
        $this->dishes = new ArrayCollection();

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Meal
     */
    public function setTitle(string $title): Meal
    {
        $this->title = $title;

        return $this;
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