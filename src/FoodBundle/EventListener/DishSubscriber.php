<?php

namespace FoodBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use FoodBundle\Entity\Dish;
use FoodBundle\Entity\Recipe;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DishSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist => 'prePersist',
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $dish = $args->getEntity();
        if ($dish instanceof Dish) {
            /** @var Recipe $recipe */
            foreach ($dish->getRecipes() as $recipe) {
                $recipe->setDish($dish);
            }
        }
    }
}