<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class IngredientNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $ingredient)
    {
        return $this->objectNormalizer->normalize($ingredient, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $ingredient)
    {
        return $this->objectNormalizer->normalize($ingredient, null, ['groups' => ['full']]);
    }
}