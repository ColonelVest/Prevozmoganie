<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RecipeNormalizer extends EntityNormalizer
{
    /** @var  DishNormalizer $dishNormalizer */
    private $dishNormalizer;
    /** @var  IngredientDataNormalizer $ingredientDataNormalizer */
    private $ingredientDataNormalizer;

    public function __construct(
        ObjectNormalizer $objectNormalizer,
        DishNormalizer $dishNormalizer,
        IngredientDataNormalizer $ingredientDataNormalizer
    ) {
        parent::__construct($objectNormalizer);
        $this->dishNormalizer = $dishNormalizer;
        $this->ingredientDataNormalizer = $ingredientDataNormalizer;
    }

    public function conciseNormalize(BaseEntity $recipe)
    {
        $dishCallback = function ($dish) {
            return $this->dishNormalizer->conciseNormalize($dish);
        };

        $ingredientsDataCallback = function ($ingredientsData) {
            $result = [];
            foreach ($ingredientsData as $ingredientData) {
                $result[] = $this->ingredientDataNormalizer->fullNormalize($ingredientData);
            }
        };

        $this->objectNormalizer->setCallbacks(
            [
                'dish' => $dishCallback,
                'ingredientData' => $ingredientsDataCallback
            ]
        );

        return $this->objectNormalizer->normalize($recipe, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $recipe)
    {
        return $this->objectNormalizer->normalize($recipe, null, ['groups' => ['full']]);
    }
}