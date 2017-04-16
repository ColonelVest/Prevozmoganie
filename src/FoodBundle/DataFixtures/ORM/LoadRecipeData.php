<?php

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\Recipe;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const RECIPE_DATA = [
        [
            'title' => 'Обычная пюрешка',
            'ingredientsData' => ['milkData', 'potatoesData'],
            'referenceName' => 'typicalMashedPotatoes',
            'dishReference' => 'mashedPotatoes'
        ],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::RECIPE_DATA as $recipeData) {
            $recipe = (new Recipe())
                ->setTitle($recipeData['title'])
                ->setDish($this->getReference($recipeData['dishReference']))
                ->setDescription($recipeData['title']);
            foreach ($recipeData['ingredientsData'] as $ingredientsData) {
                $recipe->addIngredientData($this->getReference($ingredientsData));
            }
            $manager->persist($recipe);
            $this->setReference($recipeData['referenceName'], $recipe);
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
        return 13;
    }
}