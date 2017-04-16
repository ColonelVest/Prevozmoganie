<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RecipeNormalizer extends EntityNormalizer
{
    /** @var  DishNormalizer $dishNormalizer */
    private $dishNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer, DishNormalizer $dishNormalizer)
    {
        parent::__construct($objectNormalizer);
        $this->dishNormalizer = $dishNormalizer;
    }

    public function conciseNormalize(BaseEntity $recipe)
    {
        $dishCallback = function ($dish) {
            return $this->dishNormalizer->conciseNormalize($dish);
        };

        $this->objectNormalizer->setCallbacks(
            [
                'dish' => $dishCallback,
            ]
        );

        return $this->objectNormalizer->normalize($recipe, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $recipe)
    {
        return $this->objectNormalizer->normalize($recipe, null, ['groups' => ['full']]);
    }
}