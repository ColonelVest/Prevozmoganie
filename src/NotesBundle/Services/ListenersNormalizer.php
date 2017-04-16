<?php

namespace NotesBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class ListenersNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $listener)
    {
        return $this->objectNormalizer->normalize($listener, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $listener)
    {
        return $this->objectNormalizer->normalize($listener, null, ['groups' => ['concise']]);
    }
}