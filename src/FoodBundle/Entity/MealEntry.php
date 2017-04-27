<?php

namespace FoodBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Symfony\Component\Serializer\Annotation as Serializer;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity
 * @ORM\Table(name="meal_entry")
 */
class MealEntry extends BaseEntity implements UserReferable
{
    /**
     * @var Meal
     * @ORM\ManyToOne(targetEntity="FoodBundle\Entity\Meal")
     * @Serializer\Groups({"full", "concise"})
     * @Normal\Entity(className="FoodBundle\Entity\Meal")
     */
    private $meal;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Serializer\Groups({"full", "concise"})
     * @Normal\DateTime()
     */
    private $date;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"full", "concise"})
     */
    private $isPerformed = false;

    /**
     * @return Meal
     */
    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    /**
     * @param Meal $meal
     * @return MealEntry
     */
    public function setMeal(Meal $meal): MealEntry
    {
        $this->meal = $meal;

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
     * @return MealEntry
     */
    public function setIsPerformed(bool $isPerformed): MealEntry
    {
        $this->isPerformed = $isPerformed;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return MealEntry
     */
    public function setUser(User $user): MealEntry
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return MealEntry
     */
    public function setDate(\DateTime $date): MealEntry
    {
        $this->date = $date;

        return $this;
    }
}