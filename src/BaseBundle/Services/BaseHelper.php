<?php

namespace BaseBundle\Services;


class BaseHelper
{
    public static function createDateFromString($dateString, $format = 'dmY')
    {
        return \DateTime::createFromFormat($format . 'H:i:s', $dateString . '00:00:00');
    }
}