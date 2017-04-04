<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\AbstractNormalizer;

class PeriodNormalizer extends AbstractNormalizer
{
    public function conciseNormalize(BaseEntity $period)
    {
        $this->objectNormalizer->setCallbacks(
            [
                'begin' => $this->getTimeCallback(),
                'end' => $this->getTimeCallback(),
                'date' => $this->getDateCallback()
            ]
        );

        $data = $this->objectNormalizer->normalize($period, null, array('groups' => array('concise')));

        return $data;
    }

    public function fullNormalize(BaseEntity $period)
    {
        $this->objectNormalizer->setCallbacks(
            [
                'begin' => $this->getTimeCallback(),
                'end' => $this->getTimeCallback(),
                'date' => $this->getDateCallback()
            ]
        );

        $data = $this->objectNormalizer->normalize($period, null, array('groups' => array('full')));

        return $data;
    }
}