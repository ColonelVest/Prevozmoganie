<?php

namespace BaseBundle\Controller;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use TaskBundle\Entity\Period;

class ApiNormalizer
{
    /** @var  ObjectNormalizer $objectNormalizer */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }


    public function normalizePeriods($periods)
    {
        $data = [];
        if (is_array($periods)) {
            foreach ($periods as $period) {
                $data[] = $this->conciseNormalizePeriod($period);
            }
        }

        return $data;
    }

    public function conciseNormalizePeriod(Period $period)
    {
        $timeCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime ? $dateTime->format('H:i') : '';
        };
        $normalizer = clone $this->objectNormalizer;
        $normalizer->setCallbacks(array('begin' => $timeCallback, 'end' => $timeCallback));

        $data = $normalizer->normalize($period, null, array('groups' => array('concise')));

        return $data;
    }

}