<?php

namespace ScheduleBundle\Service;

class DateTimeHandler
{
    public function getDateFromString($dateString)
    {
        if (!isset($dateString)) {
            return new \DateTime();
        }
        $date = \DateTime::createFromFormat('d-m-Y', $dateString);
        if (!$date) {
            throw new \Exception('Не надо вместо строки даты писать ересь, пожалуйста.');
        }
        return $date;
    }
}