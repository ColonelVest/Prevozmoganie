<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class IngredientDataNormalizer extends EntityNormalizer
{
    /** @var  IngredientNormalizer $ingredientNormalizer */
    private $ingredientNormalizer;

    public function __construct(ObjectNormalizer $normalizer, IngredientNormalizer $ingredientNormalizer)
    {
        parent::__construct($normalizer);
        $this->ingredientNormalizer = $ingredientNormalizer;
    }

    public function conciseNormalize(BaseEntity $ingredientData)
    {
        return $this->objectNormalizer->normalize($ingredientData, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $ingredientData)
    {
        $ingredientCallback = function ($ingredient) {
            return $this->ingredientNormalizer->conciseNormalize($ingredient);
        };

        $this->objectNormalizer->setCallbacks([
            'ingredient' => $ingredientCallback
        ]);

        return $this->objectNormalizer->normalize($ingredientData, null, ['groups' => ['full']]);
    }
}