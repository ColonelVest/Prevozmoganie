<?php

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\MealType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadMealTypeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const MEAL_TYPE_DATA = [
        ['title' => 'Завтрак', 'referenceName' => 'breakfast'],
        ['title' => 'Обед', 'referenceName' => 'lunch'],
        ['title' => 'Ужин', 'referenceName' => 'dinner'],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::MEAL_TYPE_DATA as $mealTypeData) {
            $mealType = new MealType();
            $mealType->setTitle($mealTypeData['title']);
            $manager->persist($mealType);
            $this->setReference($mealTypeData['referenceName'], $mealType);
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
        return 10;
    }
}