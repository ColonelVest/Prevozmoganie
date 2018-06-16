<?php

namespace BaseBundle\Services;


use Symfony\Component\HttpFoundation\ParameterBag;

class IterableManager
{
    public function getParamsFromBag(ParameterBag $bag, array $paramNames, $withKeys = false)
    {
        $result = [];
        foreach ($paramNames as $paramName) {
            $withKeys ? $result[$paramName] = $bag->get($paramName) : $result[] = $bag->get($paramName);
        }

        return $result;
    }
}