<?php

namespace BaseBundle\Lib\Serialization\Mapping\Loader;

use BaseBundle\Lib\Serialization\Annotation\Normal\DateTime;
use BaseBundle\Lib\Serialization\Annotation\Normal\Entity;
use BaseBundle\Lib\Serialization\Mapping\PVAttributeMetadata;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;
use Symfony\Component\Serializer\Mapping\Loader\LoaderInterface;

class PVAnnotationLoader implements LoaderInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Load class metadata.
     *
     * @param ClassMetadataInterface $classMetadata A metadata
     *
     * @return bool
     */
    public function loadClassMetadata(ClassMetadataInterface $classMetadata)
    {
        $reflectionClass = $classMetadata->getReflectionClass();
        $className = str_replace('Proxies\__CG__\\', '', $reflectionClass->name);
        $loaded = false;

        $attributesMetadata = $classMetadata->getAttributesMetadata();

        foreach ($reflectionClass->getProperties() as $property) {
            if (!isset($attributesMetadata[$property->name])) {
                $attributesMetadata[$property->name] = new PVAttributeMetadata($property->name);
                $classMetadata->addAttributeMetadata($attributesMetadata[$property->name]);
            }

            if ($property->getDeclaringClass()->name === $className) {
                foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                    $this->handleAnnotation($annotation, $attributesMetadata, $property);

                    $loaded = true;
                }
            }
        }

        foreach ($reflectionClass->getMethods() as $method) {
            if ($method->getDeclaringClass()->name !== $className) {
                continue;
            }

            $accessorOrMutator = preg_match('/^(get|is|has|set)(.+)$/i', $method->name, $matches);
            if ($accessorOrMutator) {
                $attributeName = lcfirst($matches[2]);

                if (isset($attributesMetadata[$attributeName])) {
                    $attributeMetadata = $attributesMetadata[$attributeName];
                } else {
                    $attributesMetadata[$attributeName] = $attributeMetadata = new AttributeMetadata($attributeName);
                    $classMetadata->addAttributeMetadata($attributeMetadata);
                }
            }

            foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
                if ($annotation instanceof Groups) {
                    if (!$accessorOrMutator) {
                        throw new MappingException(sprintf('Groups on "%s::%s" cannot be added. Groups can only be added on methods beginning with "get", "is", "has" or "set".', $className, $method->name));
                    }

                    foreach ($annotation->getGroups() as $group) {
                        $attributeMetadata->addGroup($group);
                    }
                } elseif ($annotation instanceof MaxDepth) {
                    if (!$accessorOrMutator) {
                        throw new MappingException(sprintf('MaxDepth on "%s::%s" cannot be added. MaxDepth can only be added on methods beginning with "get", "is", "has" or "set".', $className, $method->name));
                    }

                    $attributeMetadata->setMaxDepth($annotation->getMaxDepth());
                }

                $loaded = true;
            }
        }

        return $loaded;
    }

    /**
     * @param string $annotation
     * @param PVAttributeMetadata[] $attributesMetadata
     * @param \ReflectionProperty $property
     */
    protected function handleAnnotation($annotation,array &$attributesMetadata, \ReflectionProperty $property) {
        if ($annotation instanceof Groups) {
            foreach ($annotation->getGroups() as $group) {
                $attributesMetadata[$property->name]->addGroup($group);
            }
        } elseif ($annotation instanceof MaxDepth) {
            $attributesMetadata[$property->name]->setMaxDepth($annotation->getMaxDepth());
        } elseif ($annotation instanceof Entity) {
            $attributesMetadata[$property->name]->setClassData($annotation);
        } elseif ($annotation instanceof DateTime) {
            if ($annotation->format) {
                $format = $annotation->format;
            } else {
                $format = $annotation::FORMATS[$annotation->type];
            }
            $attributesMetadata[$property->name]->setDateTimeFormat($format);
        }
    }
}