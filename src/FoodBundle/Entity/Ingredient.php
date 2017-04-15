<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredient")
 */
class Ingredient extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;
}