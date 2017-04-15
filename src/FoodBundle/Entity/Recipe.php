<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe")
 */
class Recipe extends BaseEntity
{
    use BlameableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\IngredientData", mappedBy="recipe")
     */
    private $ingredientsData;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var Dish
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Dish")
     */
    private $dish;

    public function __construct()
    {
        $this->ingredientsData = new ArrayCollection();
    }

    /**
     * @return Dish
     */
    public function getDish(): Dish
    {
        return $this->dish;
    }

    /**
     * @param Dish $dish
     * @return Recipe
     */
    public function setDish(Dish $dish): Recipe
    {
        $this->dish = $dish;

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
     * @return Recipe
     */
    public function setTitle(string $title): Recipe
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredientsData(): ArrayCollection
    {
        return $this->ingredientsData;
    }

    /**
     * @param ArrayCollection $ingredientsData
     * @return Recipe
     */
    public function setIngredientsData(ArrayCollection $ingredientsData): Recipe
    {
        $this->ingredientsData = $ingredientsData;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Recipe
     */
    public function setDescription(string $description): Recipe
    {
        $this->description = $description;

        return $this;
    }
}