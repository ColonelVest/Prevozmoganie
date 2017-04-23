<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

class DishNormalizer extends EntityNormalizer
{
    /**
     * @var RecipeNormalizer $recipeNormalizer
     */
    private $recipeNormalizer;

    public function __construct(ClassMetadataFactory $factory, RecipeNormalizer $recipeNormalizer = null)
    {
        parent::__construct($factory);
        $this->recipeNormalizer = $recipeNormalizer;
    }

    public function conciseNormalize(BaseEntity $dish)
    {
        return $this->normalize($dish, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $dish)
    {
        $recipesCallback = function ($recipes) {
            $result = [];
            foreach ($recipes as $recipe) {
                $result[] = $this->recipeNormalizer->conciseNormalize($recipe);
            }

            return $result;
        };

        $this->setCallbacks([
            'recipes' => $recipesCallback
        ]);

        return $this->normalize($dish, null, ['groups' => ['full'], self::ENABLE_MAX_DEPTH => true]);
    }
}