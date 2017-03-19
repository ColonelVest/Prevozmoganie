<?php

namespace NotesBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class ListenersNormalizer extends AbstractNormalizer
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