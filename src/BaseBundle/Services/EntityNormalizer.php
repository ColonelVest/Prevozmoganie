<?php

namespace BaseBundle\Services;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EntityNormalizer extends ObjectNormalizer
{
    /** @var  AnnotationReader $reader */
    private $annotationReader;

    public function __construct(ClassMetadataFactory $factory, AnnotationReader $annotationReader = null)
    {
        parent::__construct($factory);
        $this->annotationReader = $annotationReader;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        return parent::normalize($object, $format, $context);
    }

    public function conciseNormalize(BaseEntity $entity)
    {
        return $this->normalize($entity, null, ['groups' => ['concise']]);
    }

    public function fullNormalize(BaseEntity $entity)
    {
        return $this->normalize($entity, null, ['groups' => ['full']]);
    }
//
//    private function getCallbacks($className)
//    {
//        $cols = $em->getClassMetadata(get_class($entity))->getColumnNames();
//    }

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