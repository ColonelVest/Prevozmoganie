<?php

namespace BaseBundle\Lib\Serialization\Mapping;

use Symfony\Component\Serializer\Mapping\AttributeMetadata;

class PVAttributeMetadata extends AttributeMetadata
{
    public $className;

    public $dateTimeFormat;

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     * @return PVAttributeMetadata
     */
    public function setClassName($className)
    {
        $this->className = $className;

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