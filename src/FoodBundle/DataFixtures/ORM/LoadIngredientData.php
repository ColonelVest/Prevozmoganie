<?php

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\Ingredient;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const INGREDIENT_DATA = [
        ['title' => 'Куриное яйцо', 'referenceName' => 'chickenEgg', 'dimension' => 'шт'],
        ['title' => 'Картофель', 'referenceName' => 'potatoes', 'dimension' => 'кг'],
        ['title' => 'Филе минтая', 'referenceName' => 'pollockFillets', 'dimension' => 'шт'],
        ['title' => 'Молоко', 'referenceName' => 'milk', 'dimension' => 'л']
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::INGREDIENT_DATA as $ingredientData) {
            $ingredient = (new Ingredient())
                ->setTitle($ingredientData['title'])
                ->setDimension($ingredientData['dimension']);

            $manager->persist($ingredient);
            $this->setReference($ingredientData['referenceName'], $ingredient);
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