<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish")
 */
class Dish extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\Recipe", mappedBy="dish")
     */
    private $recipes;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Dish
     */
    public function setTitle(string $title): Dish
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipes(): ?ArrayCollection
    {
        return $this->recipes;
    }

    /**
     * @param ArrayCollection $recipes
     * @return Dish
     */
    public function setRecipes(ArrayCollection $recipes): Dish
    {
        $this->recipes = $recipes;

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
     * @return Dish
     */
    public function setDescription(string $description): Dish
    {
        $this->description = $description;

        return $this;
    }
}