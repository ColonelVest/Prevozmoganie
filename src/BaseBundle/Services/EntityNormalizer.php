<?php

namespace BaseBundle\Services;

use BaseBundle\Entity\BaseEntity;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class EntityNormalizer extends ObjectNormalizer
{
    abstract public function conciseNormalize(BaseEntity $entity);
    abstract public function fullNormalize(BaseEntity $entity);

    public function __construct(ClassMetadataFactory $factory)
    {
        parent::__construct($factory);
    }

    public function conciseNormalizeEntities($entities)
    {
        $data = [];
        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $data[] = $this->conciseNormalize($entity);
            }
        }

        return $data;
    }

    protected function getDateCallback()
    {
        return function ($date) {
            return $this->normalizeDate($date);
        };
    }

    protected function getTimeCallback()
    {
        return function ($time) {
            return $this->normalizeTime($time);
        };
    }

    protected function normalizeDate($date, $format = 'dmY')
    {
        return $date instanceof \DateTime ? $date->format($format) : '';
    }

    protected function normalizeTime($time, $format = 'H:i')
    {
        return $time instanceof \DateTime ? $time->format($format) : '';
    }
}