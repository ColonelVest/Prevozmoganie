<?php

namespace BaseBundle\Services;

use BaseBundle\Lib\Serialization\Annotation\Normal\Entity;
use BaseBundle\Lib\Serialization\Mapping\PVAttributeMetadata;
use BaseBundle\Lib\Serialization\NormalizationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;

class PVNormalizer extends ObjectNormalizer
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  AnnotationReader $reader */
    private $reader;

    private $propertyTypeExtractor;

    public function __construct(
        ClassMetadataFactory $factory,
        PropertyAccessorInterface $propertyAccessor,
        PropertyTypeExtractorInterface $propertyTypeExtractor,
        EntityManager $em,
        AnnotationReader $reader
    ) {
        parent::__construct($factory, null, $propertyAccessor, $propertyTypeExtractor);
        $this->em = $em;
        $this->reader = $reader;
        $this->propertyTypeExtractor = $propertyTypeExtractor;
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

    //TODO: Кучу всяческих валидаций
    public function fillEntity($entity, $dataToFill, $unMappedFields = [])
    {
        $metadata = $this->classMetadataFactory->getMetadataFor($entity)->getAttributesMetadata();
        foreach ($dataToFill as $fieldName => $value) {
            if (isset($metadata[$fieldName])) {
                /** @var PVAttributeMetadata $fieldMeta */
                $fieldMeta = $metadata[$fieldName];
                if (!is_null($fieldMeta->getDateTimeFormat())) {
                    $fieldData = \DateTime::createFromFormat($fieldMeta->getDateTimeFormat(), $value);
                } elseif (!is_null($classData = $fieldMeta->getClassData())) {
                    $fieldData = $this->fillEntityField($value, $classData->className, $classData->isMultiple);
                } else {
                    $fieldData = $value;
                }

                $this->setAttributeValue($entity, $fieldName, $fieldData);
            } elseif (!in_array($fieldName, $unMappedFields)) {
                throw new NormalizationException('field "' . $fieldName . '" is extra');
            }
        }

        return $entity;
    }

    private function fillEntityField($data, $className, $isMultiple)
    {
        if ($isMultiple) {
            $fieldData = [];
            foreach ($data as $item) {
                $fieldData[] = $this->getEntityById($className, $item);
            }
        } else {
            $fieldData = $this->getEntityById($className, $data);
        }

        return $fieldData;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!isset($context['cache_key'])) {
            $context['cache_key'] = $this->getCacheKey($format, $context);
        }
        $allowedAttributes = $this->getAllowedAttributes($class, $context, true);
        $normalizedData = $this->prepareForDenormalization($data);

        if ($class === 'DateTime') {
            $format = $context['metadata']->dateTimeFormat;
            $object = \DateTime::createFromFormat($format, $data);
            if (!($object instanceof \DateTime)) {
                throw new NormalizationException('Incorrect format of '.$context['field'].' field');
            }
        } else {
            $reflectionClass = new \ReflectionClass($class);
            $object = $this->instantiateObject(
                $normalizedData,
                $class,
                $context,
                $reflectionClass,
                $allowedAttributes,
                $format
            );
            $metadata = $this->classMetadataFactory->getMetadataFor($object);
            $attributesMetadata = $metadata->getAttributesMetadata();

            foreach ($normalizedData as $attribute => $value) {
                if ($this->nameConverter) {
                    $attribute = $this->nameConverter->denormalize($attribute);
                }

                if (($allowedAttributes !== false && !in_array(
                            $attribute,
                            $allowedAttributes
                        )) || !$this->isAllowedAttribute($class, $attribute, $format, $context)
                ) {
                    continue;
                }
                $context['metadata'] = $attributesMetadata[$attribute];
                $context['field'] = $attribute;

                $value = $this->validateAndDenormalize($class, $attribute, $value, $format, $context);
                try {
                    $this->setAttributeValue($object, $attribute, $value, $format, $context);
                } catch (InvalidArgumentException $e) {
                    throw new UnexpectedValueException($e->getMessage(), $e->getCode(), $e);
                }
            }
        }

        return $object;
    }

    private function getEntityById($className, $id)
    {
        return $this->em->find($className, $id);
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

    public function fullNormalize($entity)
    {
        return $this->normalize($entity, null, ['groups' => ['full']]);
    }

    /**
     * Validates the submitted data and denormalizes it.
     *
     * @param string $currentClass
     * @param string $attribute
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     *
     * @return mixed
     *
     * @throws UnexpectedValueException
     * @throws LogicException
     */
    private function validateAndDenormalize($currentClass, $attribute, $data, $format, array $context)
    {
        if (null === $this->propertyTypeExtractor || null === $types = $this->propertyTypeExtractor->getTypes(
                $currentClass,
                $attribute
            )
        ) {
            return $data;
        }

        $expectedTypes = array();
        foreach ($types as $type) {
            if (null === $data && $type->isNullable()) {
                return null;
            }

            if ($type->isCollection() && null !== ($collectionValueType = $type->getCollectionValueType(
                )) && Type::BUILTIN_TYPE_OBJECT === $collectionValueType->getBuiltinType()
            ) {
                $builtinType = Type::BUILTIN_TYPE_OBJECT;
                $class = $collectionValueType->getClassName().'[]';

                if (null !== $collectionKeyType = $type->getCollectionKeyType()) {
                    $context['key_type'] = $collectionKeyType;
                }
            } else {
                $builtinType = $type->getBuiltinType();
                $class = $type->getClassName();
            }

            $expectedTypes[Type::BUILTIN_TYPE_OBJECT === $builtinType && $class ? $class : $builtinType] = true;

            if (Type::BUILTIN_TYPE_OBJECT === $builtinType) {
                if (!$this->serializer instanceof DenormalizerInterface) {
                    throw new LogicException(
                        sprintf(
                            'Cannot denormalize attribute "%s" for class "%s" because injected serializer is not a denormalizer',
                            $attribute,
                            $class
                        )
                    );
                }

                if ($this->serializer->supportsDenormalization($data, $class, $format)) {
                    return $this->serializer->denormalize($data, $class, $format, $context);
                }
            }

            // JSON only has a Number type corresponding to both int and float PHP types.
            // PHP's json_encode, JavaScript's JSON.stringify, Go's json.Marshal as well as most other JSON encoders convert
            // floating-point numbers like 12.0 to 12 (the decimal part is dropped when possible).
            // PHP's json_decode automatically converts Numbers without a decimal part to integers.
            // To circumvent this behavior, integers are converted to floats when denormalizing JSON based formats and when
            // a float is expected.
            if (Type::BUILTIN_TYPE_FLOAT === $builtinType && is_int($data) && false !== strpos(
                    $format,
                    JsonEncoder::FORMAT
                )
            ) {
                return (float)$data;
            }

            if (call_user_func('is_'.$builtinType, $data)) {
                return $data;
            }
        }

        throw new UnexpectedValueException(
            sprintf(
                'The type of the "%s" attribute for class "%s" must be one of "%s" ("%s" given).',
                $attribute,
                $currentClass,
                implode('", "', array_keys($expectedTypes)),
                gettype($data)
            )
        );
    }

    protected function getNormalizeEntityCallback()
    {
        return function ($entity) {
            return $this->normalizeNested($entity);
        };
    }

    /**
     * Gets the cache key to use.
     *
     * @param string|null $format
     * @param array $context
     *
     * @return bool|string
     */
    private function getCacheKey($format, array $context)
    {
        try {
            return md5($format.serialize($context));
        } catch (\Exception $exception) {
            // The context cannot be serialized, skip the cache
            return false;
        }
    }

    protected function normalizeDateTime($date, $format)
    {
        return $date instanceof \DateTime ? $date->format($format) : '';
    }
}