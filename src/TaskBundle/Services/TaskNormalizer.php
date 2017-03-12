<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class TaskNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $task)
    {
        $dateCallback = function ($date) {
            return $this->normalizeDate($date);
        };
        $timeCallback = function ($time) {
            return $this->normalizeTime($time);
        };
        $this->objectNormalizer->setCallbacks(
            ['date' => $dateCallback, 'beginTime' => $timeCallback, 'endTime' => $timeCallback]
        );

        return $this->objectNormalizer->normalize($task, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $task)
    {
        $dateCallback = function ($date) {
            return $this->normalizeDate($date);
        };
        $timeCallback = function ($time) {
            return $this->normalizeTime($time);
        };
        $this->objectNormalizer->setCallbacks(
            ['date' => $dateCallback, 'beginTime' => $timeCallback, 'endTime' => $timeCallback]
        );

        return $this->objectNormalizer->normalize($task, null, ['groups' => ['full']]);
    }
}