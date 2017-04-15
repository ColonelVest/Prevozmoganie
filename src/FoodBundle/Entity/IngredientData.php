<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredient_data")
 */
class IngredientData extends BaseEntity
{
    /**
     * @var Ingredient
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Ingredient")
     */
    private $ingredient;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $count;

    /**
     * @var Recipe
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Recipe")
     */
    private $recipe;

    /**
     * @return Recipe
     */
    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    /**
     * @param Recipe $recipe
     * @return IngredientData
     */
    public function setRecipe(Recipe $recipe): IngredientData
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Ingredient
     */
    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    /**
     * @param Ingredient $ingredient
     * @return IngredientData
     */
    public function setIngredient(Ingredient $ingredient): IngredientData
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return IngredientData
     */
    public function setCount(int $count): IngredientData
    {
        $this->count = $count;

        return $this;
    }
}