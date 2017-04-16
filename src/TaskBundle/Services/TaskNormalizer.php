<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class TaskNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $task)
    {
        $this->objectNormalizer->setCallbacks(
            [
                'date' => $this->getDateCallback(),
                'deadline' => $this->getDateCallback(),
                'beginTime' => $this->getTimeCallback(),
                'endTime' => $this->getTimeCallback(),
            ]
        );

        return $this->objectNormalizer->normalize($task, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $task)
    {
        $this->objectNormalizer->setCallbacks(
            [
                'date' => $this->getDateCallback(),
                'deadline' => $this->getDateCallback(),
                'beginTime' => $this->getTimeCallback(),
                'endTime' => $this->getTimeCallback(),
            ]
        );

        return $this->objectNormalizer->normalize($task, null, ['groups' => ['full']]);
    }
}