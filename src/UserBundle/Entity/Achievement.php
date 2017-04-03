<?php

namespace UserBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="achievements")
 * Class Achievement
 * @package UserBundle\Entity
 */
class Achievement extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \DateInterval
     * @ORM\Column(type="string")
     */
    private $dateInterval;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $classType;

    /**
     * @return string
     */
    public function getClassType(): ?string
    {
        return $this->classType;
    }

    /**
     * @param string $classType
     * @return Achievement
     */
    public function setClassType(string $classType): Achievement
    {
        $this->classType = $classType;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Achievement
     */
    public function setName(string $name): Achievement
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateInterval
     */
    public function getDateInterval(): ?\DateInterval
    {
        return new \DateInterval($this->dateInterval);
    }

    /**
     * @param string $dateIntervalString
     * @return Achievement
     */
    public function setDateInterval(string $dateIntervalString): Achievement
    {
        $this->dateInterval = $dateIntervalString;

        return $this;
    }
}