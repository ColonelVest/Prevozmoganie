<?php

namespace BaseBundle\Services;


class BaseHelper
{
    /**
     * @param $dateString
     * @param string $format
     * @return bool|\DateTime
     */
    public static function createDateFromString($dateString, $format = 'dmY')
    {
        return \DateTime::createFromFormat($format . 'H:i:s', $dateString . '00:00:00');
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
}