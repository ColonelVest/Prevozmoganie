<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish")
 */
class Dish extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full"})
     */
    private $title;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\Recipe", mappedBy="dish", cascade={"persist", "remove"})
     * @Groups({"full"})
     * @MaxDepth(1)
     */
    private $recipes;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     */
    private $description;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
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
     * @return Dish
     */
    public function setTitle(string $title): Dish
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getRecipes(): ?Collection
    {
        return $this->recipes;
    }

    /**
     * @param Collection $recipes
     * @return Dish
     */
    public function setRecipes(Collection $recipes): Dish
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