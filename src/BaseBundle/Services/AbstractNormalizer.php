<?php

namespace BaseBundle\Services;

use BaseBundle\Entity\BaseEntity;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractNormalizer
{
    /** @var  ObjectNormalizer $objectNormalizer */
    protected $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    abstract public function conciseNormalize(BaseEntity $entity);
    abstract public function fullNormalize(BaseEntity $entity);

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

    protected function normalizeDate($date, $format = 'dmY')
    {
        return $date instanceof \DateTime ? $date->format($format) : '';
    }

    protected function normalizeTime($time, $format = 'H:i')
    {
        return $time instanceof \DateTime ? $time->format($format) : '';
    }
}