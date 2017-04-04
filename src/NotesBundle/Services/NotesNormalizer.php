<?php

namespace NotesBundle\Services;


use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class NotesNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $note)
    {
        return $this->objectNormalizer->normalize($note, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $note)
    {
        return $this->objectNormalizer->normalize($note, null, ['groups' => ['full']]);
    }
}