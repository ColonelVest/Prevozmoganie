<?php

namespace BaseBundle\Services;

use BaseBundle\Lib\Serialization\Annotation\Normal\Entity;
use BaseBundle\Lib\Serialization\Mapping\PVAttributeMetadata;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PVNormalizer extends ObjectNormalizer
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  AnnotationReader $reader */
    private $reader;

    public function __construct(ClassMetadataFactory $factory, EntityManager $em, AnnotationReader $reader)
    {
        parent::__construct($factory);
        $this->em = $em;
        $this->reader = $reader;
    }

    //TODO: Тут все конечно уродливо, но потом отрефакторю
    public function normalize($object, $format = null, array $context = array())
    {
        $metadata = $this->classMetadataFactory->getMetadataFor($object);
        foreach ($metadata->getAttributesMetadata() as $propertyData) {
            if ($propertyData instanceof PVAttributeMetadata) {
                /** @var Entity $entityData */
                if ($entityData = $propertyData->getClassData()) {
                    if ($entityData->isMultiple) {
                        $callback = function ($entities) {
                            return $this->conciseNormalizeEntities($entities);
                        };
                    } else {
                        $callback = $this->getNormalizeEntityCallback();
                    }
                    $this->callbacks[$propertyData->getName()] = $callback;
                } elseif ($entityData = $propertyData->getDateTimeFormat()) {
                    $callback = function ($dateTime) use ($propertyData) {
                        return $this->normalizeDateTime($dateTime, $propertyData->getDateTimeFormat());
                    };
                    $this->callbacks[$propertyData->getName()] = $callback;
                }
            }
        }

        $context[self::ENABLE_MAX_DEPTH] = true;

        return parent::normalize($object, $format, $context);
    }

    public function conciseNormalize($entity)
    {
        return $this->normalize($entity, null, ['groups' => ['concise']]);
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

    public function fullNormalize($entity)
    {
        return $this->normalize($entity, null, ['groups' => ['full']]);
    }

    protected function getNormalizeEntityCallback()
    {
        return function ($entity) {
            return $this->conciseNormalize($entity);
        };
    }

    protected function normalizeDateTime($date, $format)
    {
        return $date instanceof \DateTime ? $date->format($format) : '';
    }
}