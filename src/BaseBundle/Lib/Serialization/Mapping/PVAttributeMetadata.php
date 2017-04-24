<?php

namespace BaseBundle\Lib\Serialization\Mapping;

use BaseBundle\Lib\Serialization\Annotation\Normal\Entity;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;

class PVAttributeMetadata extends AttributeMetadata
{
    /**
     * @var array
     */
    public $classData;

    /**
     * @var string
     */
    public $dateTimeFormat;

    /**
     * @return mixed
     */
    public function getClassData()
    {
        return $this->classData;
    }

    /**
     * @param Entity $entityData
     * @return PVAttributeMetadata
     */
    public function setClassData(Entity $entityData)
    {
        $this->classData = $entityData;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * @param mixed $dateTimeFormat
     * @return PVAttributeMetadata
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    /**
     * Returns the names of the properties that should be serialized.
     *
     * @return string[]
     */
    public function __sleep()
    {
        return array('name', 'groups', 'maxDepth', 'dateTimeFormat', 'className');
    }
}