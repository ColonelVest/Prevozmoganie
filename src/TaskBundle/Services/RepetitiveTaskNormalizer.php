<?php

namespace TaskBundle\Services;


use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class RepetitiveTaskNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $task)
    {
        return $this->objectNormalizer->normalize($task, null, ['groups' => ['concise']]);
    }
}