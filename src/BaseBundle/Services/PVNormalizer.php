<?php

namespace BaseBundle\Services;

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

    public function getMetadata($obj)
    {
        return $this->classMetadataFactory->getMetadataFor($obj);
    }

//    private $isCallbacksInit = false;
//    private $callbacks = [];
//    public function getCallbacks($className)
//    {
//        if (!$this->isCallbacksInit) {
//            $reflectionClass = new \ReflectionClass($className);
//            foreach ($reflectionClass->getProperties() as $property) {
//
//            }
//            $cols = $this->em->getClassMetadata($className)->getColumnNames();
//            foreach ($cols as $propertyName) {
//                $annotation = $this->reader->getPropertyAnnotations(new \ReflectionProperty($className, $propertyName));
//
//            }
//            $this->isCallbacksInit = true;
//        }
//
//        return $this->callbacks;
//    }
}