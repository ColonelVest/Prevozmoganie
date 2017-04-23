<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredient_data")
 */
class IngredientData extends BaseEntity
{
    /**
     * @var Ingredient
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Ingredient")
     * @Serializer\Groups({"full"})
     * @Normal\Entity(className="FoodBundle\Entity\Ingredient")
     */
    private $ingredient;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Serializer\Groups({"concise", "full"})
     */
    private $count;

    /**
     * @var Recipe
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Recipe")
     * @Serializer\MaxDepth(1)
     * @Serializer\Groups({"full"})
     * @Normal\Entity(className="FoodBundle\Entity\Recipe")
     */
    private $recipe;

    /**
     * @return Recipe
     */
    public function getRecipe(): ?Recipe
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
    public function getIngredient(): ?Ingredient
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
     * @return float
     */
    public function getCount(): ?float
    {
        return $this->count;
    }

    /**
     * @param float $count
     * @return IngredientData
     */
    public function setCount(float $count): IngredientData
    {
        $this->count = $count;

        return $this;
    }
}