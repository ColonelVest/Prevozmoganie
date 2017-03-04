<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\ApiNormalizer;

class TaskNormalizer extends ApiNormalizer
{
    public function conciseNormalize(BaseEntity $task)
    {
        return $this->objectNormalizer->normalize($task, null, ['groups' => ['concise']]);
    }
}