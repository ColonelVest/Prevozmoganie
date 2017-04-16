<?php

namespace FoodBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class DishNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $dish)
    {
        return $this->objectNormalizer->normalize($dish, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $dish)
    {
        return $this->objectNormalizer->normalize($dish, null, ['groups' => ['full']]);
    }
}