<?php

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\IngredientData;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadIngredientDataData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const INGREDIENT_DATA = [
        ['ingredient' => 'chickenEgg', 'count' => 5],
        ['ingredient' => 'potatoes', 'count' => 0.5],
        ['ingredient' => 'pollockFillets', 'count' => 2],
        ['ingredient' => 'milk', 'count' => 0.5],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::INGREDIENT_DATA as $ingredientData) {
            $ingredientDataObj = (new IngredientData())
                ->setCount($ingredientData['count'])
                ->setIngredient($this->getReference($ingredientData['ingredient']));
            $manager->persist($ingredientDataObj);
            $this->setReference($ingredientData['ingredient'] . 'Data', $ingredientDataObj);
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
        return 12;
    }
}