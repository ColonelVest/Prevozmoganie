<?php

namespace FoodBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use FoodBundle\Entity\IngredientData;
use FoodBundle\Entity\Recipe;

class RecipeSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist => 'prePersist'
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $recipe = $args->getEntity();
        if ($recipe instanceof Recipe) {
            /** @var IngredientData $ingredientData */
            foreach ($recipe->getIngredientsData() as $ingredientData) {
                $ingredientData->setRecipe($recipe);
            }
        }
    }
}