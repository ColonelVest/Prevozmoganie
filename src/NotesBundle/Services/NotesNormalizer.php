<?php

namespace NotesBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class NotesNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $note)
    {
        return $this->normalize($note, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $note)
    {
        return $this->normalize($note, null, ['groups' => ['full']]);
    }
}