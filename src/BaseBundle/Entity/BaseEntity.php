<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

abstract class BaseEntity
{
    /**
     * @var integer
     * @ORM\Id
     * @Groups({"full", "concise", "nested"})
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function getName()
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

    public static function getShortName()
    {
        return strtolower((new \ReflectionClass(static::class))->getShortName());
    }
}