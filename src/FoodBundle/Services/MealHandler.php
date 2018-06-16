<?php

namespace FoodBundle\Services;

use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FoodBundle\Entity\Meal;
use FoodBundle\Entity\MealEntry;
use FoodBundle\Entity\MealEntryRepository;
use FoodBundle\Model\RepetitiveMeal;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Services\TaskHandler;

class MealHandler extends EntityHandler
{
    /**
     * @var BaseHelper
     */
    private $helper;
    /**
     * @var TaskHandler
     */
    private $taskHandler;

    /**
     * MealHandler constructor.
     * @param EntityManager $em
     * @param RecursiveValidator $validator
     * @param BaseHelper $helper
     * @param TaskHandler $taskHandler
     */
    public function __construct(
        EntityManager $em,
        RecursiveValidator $validator,
        BaseHelper $helper,
        TaskHandler $taskHandler
    ) {
        parent::__construct($em, $validator);
        $this->helper = $helper;
        $this->taskHandler = $taskHandler;
    }

    /**
     * @param RepetitiveMeal $repetitiveMeal
     * @return Result
     */
    public function generateMealEntries(RepetitiveMeal $repetitiveMeal)
    {
        $days = $this->helper->getDaysByDateCondition($repetitiveMeal);
        $meal = (new Meal())
            ->setMealType($repetitiveMeal->getMealType())
            ->setTitle($repetitiveMeal->getTitle());
        foreach ($repetitiveMeal->getDishes() as $dish) {
            $meal->addDish($dish);
        }
        $this->em->persist($meal);

        $existedMealEntries = $this->getRepository()->getByCriteria(
            $repetitiveMeal->getBeginDate(),
            $repetitiveMeal->getEndDate(),
            $repetitiveMeal->getUser(),
            $repetitiveMeal->getMealType()
        );

        $entriesByDates = $this->helper->getArrayWithKeysByDate($existedMealEntries);

        foreach ($days as $day) {
            if (isset($entriesByDates[$day->format('d.m.Y')])) {
                $oldMealEntry = $entriesByDates[$day->format('d.m.Y')];
                $this->em->remove($oldMealEntry);
            }

            $mealEntry = (new MealEntry())
                ->setMeal($meal)
                ->setUser($repetitiveMeal->getUser())
                ->setDate($day);
            $this->em->persist($mealEntry);
        }

        $this->em->flush();

        if ($repetitiveMeal->isNewMealsCreateTask()) {
            $title = 'Заполнить данные о питании для типа питания '.$meal->getMealType()->getTitle();
            $this->taskHandler->createTaskOfCreationNewEntities(
                $repetitiveMeal->getEndDate(),
                $repetitiveMeal->getUser(),
                $title
            );
        }

        return Result::createSuccessResult();
    }

    /**
     * @return EntityRepository|MealEntryRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('FoodBundle:MealEntry');
    }
}