<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

class RecipeNormalizer extends EntityNormalizer
{
    /** @var  DishNormalizer $dishNormalizer */
    private $dishNormalizer;
    /** @var  IngredientDataNormalizer $ingredientDataNormalizer */
    private $ingredientDataNormalizer;

    public function __construct(
        ClassMetadataFactory $factory,
        DishNormalizer $dishNormalizer = null,
        IngredientDataNormalizer $ingredientDataNormalizer = null
    ) {
        parent::__construct($factory);
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

        $this->setCallbacks(
            [
                'dish' => $dishCallback,
                'ingredientData' => $ingredientsDataCallback
            ]
        );

        return $this->normalize($recipe, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $recipe)
    {
        $ingredientsDataCallback = function ($ingredientsData) {
            $result = [];
            foreach ($ingredientsData as $ingredientData) {
                $result[] = $this->ingredientDataNormalizer->fullNormalize($ingredientData);
            }
        };

        $dishCallback = function ($dish) {
            return $this->dishNormalizer->conciseNormalize($dish);
        };

        $this->setCallbacks(
            [
                'dish' => $dishCallback,
                'ingredientData' => $ingredientsDataCallback
            ]
        );

        return $this->normalize($recipe, null, [self::ENABLE_MAX_DEPTH => true, 'groups' => ['full']]);
    }
}