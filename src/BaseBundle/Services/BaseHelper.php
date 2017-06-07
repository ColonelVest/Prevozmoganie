<?php

namespace BaseBundle\Services;

use BaseBundle\Entity\DateCondition;
use BaseBundle\Models\RepetitiveInterface;

class BaseHelper
{
    /**
     * @param $dateString
     * @param string $format
     * @return bool|\DateTime
     */
    public function createDateFromString($dateString, $format = 'dmY')
    {
        return \DateTime::createFromFormat($format.'H:i:s', $dateString.'00:00:00');
    }

    /**
     * @param array $entities
     * @param string $methodName
     * @return array
     */
    public function getArrayWithKeysByMethodName(array $entities, $methodName = 'getId')
    {
        $resultArray = [];
        foreach ($entities as $entity) {
            $key = $entity->{$methodName}();
            $resultArray[$key] = $entity;
        }

        return $resultArray;
    }

    /**
     * @param array $entities
     * @param string $methodName
     * @param string $format
     * @return array
     */
    public function getArrayWithKeysByDate(array $entities, $methodName = 'getDate', $format = 'd.m.Y')
    {
        $resultArray = [];
        foreach ($entities as $entity) {
            $key = $entity->{$methodName}()->format($format);
            $resultArray[$key] = $entity;
        }

        return $resultArray;
    }

    /**
     * @param DateCondition $condition
     * @return \DateTime[]
     */
    public function getDaysByDateCondition(DateCondition $condition)
    {
        $days = [];
        if (count($condition->getDates()) > 0) {
            foreach ($condition->getDates() as $date) {
                $days[] = $this->createDateFromString($date);
            }
        } else {
            $end = (clone $condition->getEndDate())->add(new \DateInterval('P1D'));

            $period = new \DatePeriod($condition->getBeginDate(), new \DateInterval('P1D'), $end);
            foreach ($period as $dayNumber => $day) {
                $weekNumber = floor($dayNumber / 7);
                /** @var \DateTime $day */
                if (($weekNumber % $condition->getWeekFrequency()) == 0) {
                    $dayOfWeek = $day->format('D');
                    if (count($condition->getDaysOfWeek()) == 0
                        || in_array(strtolower($dayOfWeek), $condition->getDaysOfWeek())
                    ) {
                        $days[] = $day;
                    }
                }
            }
        }

        return $days;
    }
}