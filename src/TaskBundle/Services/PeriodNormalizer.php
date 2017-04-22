<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Services\EntityNormalizer;

class PeriodNormalizer extends EntityNormalizer
{
    public function conciseNormalize(BaseEntity $period)
    {
        $this->setCallbacks(
            [
                'begin' => $this->getTimeCallback(),
                'end' => $this->getTimeCallback(),
                'date' => $this->getDateCallback()
            ]
        );

        $data = $this->normalize($period, null, array('groups' => array('concise')));

        return $data;
    }

    public function fullNormalize(BaseEntity $period)
    {
        $this->setCallbacks(
            [
                'begin' => $this->getTimeCallback(),
                'end' => $this->getTimeCallback(),
                'date' => $this->getDateCallback()
            ]
        );

        $data = $this->normalize($period, null, array('groups' => array('full')));

        return $data;
    }
}