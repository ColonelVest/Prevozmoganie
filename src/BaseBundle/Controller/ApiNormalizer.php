<?php

namespace BaseBundle\Controller;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use TaskBundle\Entity\Period;
use TaskBundle\Entity\Schedule;

class ApiNormalizer
{
    /** @var  ObjectNormalizer $objectNormalizer */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function conciseNormalizeSchedule(Schedule $schedule)
    {
        $dateCallback = function ($date) {
            return $date instanceof \DateTime ? $date->format('Y-m-d') : '';
        };
        $periodCallback = function ($periods) {
            return $this->normalizePeriods($periods);
        };
        $this->objectNormalizer->setCallbacks(['date' => $dateCallback, 'periods' => $periodCallback,]);

        $data = $this->objectNormalizer->normalize($schedule, null, ['groups' => ['full_1']]);

        return $data;
    }

    public function normalizePeriods($periods)
    {
        $data = [];
        foreach ($periods as $period) {
            $data[] = $this->conciseNormalizePeriod($period);
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