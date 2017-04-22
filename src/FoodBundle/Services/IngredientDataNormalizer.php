<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

class IngredientDataNormalizer extends EntityNormalizer
{
    /** @var  IngredientNormalizer $ingredientNormalizer */
    private $ingredientNormalizer;

    public function __construct(ClassMetadataFactory $factory, IngredientNormalizer $ingredientNormalizer)
    {
        parent::__construct($factory);
        $this->ingredientNormalizer = $ingredientNormalizer;
    }

    public function conciseNormalize(BaseEntity $ingredientData)
    {
        return $this->normalize($ingredientData, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $ingredientData)
    {
        $ingredientCallback = function ($ingredient) {
            return $this->ingredientNormalizer->conciseNormalize($ingredient);
        };

        $this->setCallbacks([
            'ingredient' => $ingredientCallback
        ]);

        return $this->normalize($ingredientData, null, ['groups' => ['full']]);
    }
}