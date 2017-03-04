<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class PeriodNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $period)
    {
        $timeCallback = function ($dateTime) {
            return $this->normalizeTime($dateTime);
        };
        $dateCallback = function ($date) {
            return $this->normalizeDate($date);
        };
        $this->objectNormalizer->setCallbacks(
            ['begin' => $timeCallback, 'end' => $timeCallback, 'date' => $dateCallback]
        );

        $data = $this->objectNormalizer->normalize($period, null, array('groups' => array('concise')));

        return $data;
    }
}