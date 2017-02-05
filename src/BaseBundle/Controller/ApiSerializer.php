<?php

namespace BaseBundle\Controller;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TaskBundle\Entity\Period;

class ApiSerializer
{
    /** @var  ObjectNormalizer $objectNormalizer */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function conciseSerializePeriod(Period $period)
    {
        $encoder = new JsonEncoder();

        $timeCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime ? $dateTime->format('H:i') : '';
        };

        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime ? $dateTime->format('Y-m-d') : '';
        };

        $this->objectNormalizer->setCallbacks(array('begin' => $timeCallback, 'end' => $timeCallback));

        $serializer = new Serializer([$this->objectNormalizer], array($encoder));
        $data = $serializer->normalize($period, null, array('groups' => array('concise')));

        return $serializer->serialize($data, 'json');
    }
}