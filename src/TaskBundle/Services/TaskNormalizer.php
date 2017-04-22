<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class TaskNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $task)
    {
        $this->setCallbacks(
            [
                'date' => $this->getDateCallback(),
                'deadline' => $this->getDateCallback(),
                'beginTime' => $this->getTimeCallback(),
                'endTime' => $this->getTimeCallback(),
            ]
        );

        return $this->normalize($task, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $task)
    {
        $this->setCallbacks(
            [
                'date' => $this->getDateCallback(),
                'deadline' => $this->getDateCallback(),
                'beginTime' => $this->getTimeCallback(),
                'endTime' => $this->getTimeCallback(),
            ]
        );

        return $this->normalize($task, null, ['groups' => ['full']]);
    }
}