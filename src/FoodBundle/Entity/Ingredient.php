<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredient")
 */
class Ingredient extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full", "nested"})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Choice(callback="getDimensionsList")
     * @Groups({"concise", "full", "nested"})
     */
    private $dimension;

    /**
     * @return string
     */
    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    /**
     * @param string $dimension
     * @return Ingredient
     */
    public function setDimension(string $dimension): Ingredient
    {
        $this->dimension = $dimension;

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
     * @return Ingredient
     */
    public function setTitle(string $title): Ingredient
    {
        $this->title = $title;

        return $this;
    }

    public static function getDimensionsList() {
        return [
            'кг', 'г', 'шт', 'л', 'm3', 'уп.'
        ];
    }
}