<?php

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FoodBundle\Entity\Dish;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadDishData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const DISH_DATA = [
        ['title' => 'Картофельное пюре', 'referenceName' => 'mashedPotatoes'],
        ['title' => 'Вареный рис', 'referenceName' => 'cookedRice'],
        ['title' => 'Гречка с маслом', 'referenceName' => 'buckwheatWithButter'],
        ['title' => 'Макарошки с сыром', 'referenceName' => 'pastaWithCheese'],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DISH_DATA as $dishData) {
            $dish = (new Dish())
                ->setTitle($dishData['title'])
                ->setDescription($dishData['title']);
            $manager->persist($dish);
            $this->setReference($dishData['referenceName'], $dish);
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
        return 11;
    }
}