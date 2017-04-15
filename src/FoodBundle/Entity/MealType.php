<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="meal_type")
 */
class MealType extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return MealType
     */
    public function setName(string $name): MealType
    {
        $this->name = $name;

        return $this;
    }
}