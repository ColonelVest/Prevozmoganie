<?php

namespace FoodBundle\Model;

use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\RepetitiveInterface;
use Doctrine\Common\Collections\Collection;
use FoodBundle\Entity\Dish;
use FoodBundle\Entity\MealType;
use UserBundle\Entity\User;

class RepetitiveMeal implements RepetitiveInterface, UserReferable
{
    private $title;

    /**
     * @var MealType
     */
    private $mealType;

    /**
     * @var Dish[]
     */
    private $dishes;

    /**
     * @var \DateTime
     */
    private $beginDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var array
     */
    private $daysOfWeek = [];

    /**
     * @var number
     */
    private $weekFrequency;

    /**
     * @var bool
     */
    private $newMealsCreateTask = false;

    /**
     * @var User
     */
    private $user;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return RepetitiveMeal
     */
    public function setTitle($title)
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
     * @return RepetitiveMeal
     */
    public function setMealType(MealType $mealType): RepetitiveMeal
    {
        $this->mealType = $mealType;

        return $this;
    }

    /**
     * @return Collection|Dish[]|null
     */
    public function getDishes(): ?Collection
    {
        return $this->dishes;
    }

    /**
     * @param Dish[] $dishes
     * @return RepetitiveMeal
     */
    public function setDishes($dishes): RepetitiveMeal
    {
        $this->dishes = $dishes;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate(): ?\DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     * @return RepetitiveMeal
     */
    public function setBeginDate(\DateTime $beginDate): RepetitiveMeal
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return RepetitiveMeal
     */
    public function setEndDate(\DateTime $endDate): RepetitiveMeal
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return array
     */
    public function getDaysOfWeek(): ?array
    {
        return $this->daysOfWeek;
    }

    /**
     * @param array $daysOfWeek
     * @return RepetitiveMeal
     */
    public function setDaysOfWeek(array $daysOfWeek): RepetitiveMeal
    {
        $this->daysOfWeek = $daysOfWeek;

        return $this;
    }

    /**
     * @return int|null|number
     */
    public function getWeekFrequency(): ?int
    {
        return $this->weekFrequency;
    }

    /**
     * @param number $weekFrequency
     * @return RepetitiveMeal
     */
    public function setWeekFrequency($weekFrequency): RepetitiveMeal
    {
        $this->weekFrequency = $weekFrequency;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNewMealsCreateTask(): ?bool
    {
        return $this->newMealsCreateTask;
    }

    /**
     * @param bool $newMealsCreateTask
     * @return RepetitiveMeal
     */
    public function setNewMealsCreateTask(bool $newMealsCreateTask): RepetitiveMeal
    {
        $this->newMealsCreateTask = $newMealsCreateTask;

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
     * @return RepetitiveMeal
     */
    public function setUser(User $user): RepetitiveMeal
    {
        $this->user = $user;

        return $this;
    }

}