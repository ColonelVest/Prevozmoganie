<?php

namespace FoodBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\Meal;
use FoodBundle\Entity\MealEntry;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadMealData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const MEAL_DATA = [
        ['title' => 'Завтрак гречкой', 'mealType' => 'breakfast', 'dishes' => ['buckwheatWithButter']],
        ['title' => 'Ужин макарошками', 'mealType' => 'dinner', 'dishes' => ['pastaWithCheese']],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $begin = new \DateTime('-20 days');
        $end = new \DateTime('+5 days');
        foreach (self::MEAL_DATA as $index => $mealData) {
            $meal = (new Meal())
                ->setTitle($mealData['title'])
                ->setMealType($this->getReference($mealData['mealType']));
            foreach ($mealData['dishes'] as $dishReference) {
                $meal->addDish($this->getReference($dishReference));
            }
            /** @var \DateTime $day */
            foreach (new \DatePeriod($begin, new \DateInterval('P1D'), $end) as $day) {
                $mealEntry = (new MealEntry())
                    ->setUser($this->getReference('fixt_user'))
                    ->setDate(clone $day)
                    ->setMeal($meal);
                $manager->persist($mealEntry);
            }
            $manager->persist($meal);
            $this->setReference($mealData['mealType'] . $index, $meal);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 14;
    }
}