<?php

namespace BaseBundle\Services;

use BaseBundle\Lib\Serialization\Annotation\Normal\Entity;
use BaseBundle\Lib\Serialization\Mapping\PVAttributeMetadata;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PVNormalizer extends ObjectNormalizer
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  AnnotationReader $reader */
    private $reader;

    public function __construct(
        ClassMetadataFactory $factory,
        NameConverterInterface $nameConverter,
        PropertyAccessorInterface $propertyAccessor,
        PropertyTypeExtractorInterface $propertyTypeExtractor,
        EntityManager $em,
        AnnotationReader $reader
    ) {
        parent::__construct($factory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);
        $this->em = $em;
        $this->reader = $reader;
    }

    //TODO: Отрефакторить
    public function normalize($object, $format = null, array $context = array())
    {
        if (is_null($object)) {
            return null;
        }

        $metadata = $this->classMetadataFactory->getMetadataFor($object);
        foreach ($metadata->getAttributesMetadata() as $propertyData) {
            if ($propertyData instanceof PVAttributeMetadata) {
                /** @var Entity $entityData */
                if ($entityData = $propertyData->getClassData()) {
                    if ($entityData->isMultiple) {
                        $callback = function ($entities) {
                            return $this->normalizeNestedEntities($entities);
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

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return parent::denormalize($data, $class, $format, $context);
    }

    public function normalizeNested($entity)
    {
        return $this->normalize($entity, null, ['groups' => ['nested']]);
    }

    public function normalizeNestedEntities($entities)
    {
        $data = [];
        if (is_array($entities)) {
            foreach ($entities as $entity) {
                $data[] = $this->normalizeNested($entity);
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type !== 'DateTime' && class_exists($type);
    }

    public function fullNormalize($entity)
    {
        return $this->normalize($entity, null, ['groups' => ['full']]);
    }

    protected function getNormalizeEntityCallback()
    {
        return function ($entity) {
            return $this->normalizeNested($entity);
        };
    }

    protected function normalizeDateTime($date, $format)
    {
        return $date instanceof \DateTime ? $date->format($format) : '';
    }
}