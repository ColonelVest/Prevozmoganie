<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="periods")
 */
class Period extends BaseEntity
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="expected_period_duration")
     */
    private $duration;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $realDuration;

    /**
     * @var string
     * Gedmo\Versioned
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $internalNumber;


    /**
     * @return mixed
     */
    public function getInternalNumber() {
        return $this->internalNumber;
    }

    /**
     * @param mixed $internalNumber
     */
    public function setInternalNumber($internalNumber) {
        $this->internalNumber = $internalNumber;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getRealDuration()
    {
        return $this->realDuration;
    }

    /**
     * @param int $realDuration
     */
    public function setRealDuration(int $realDuration)
    {
        $this->realDuration = $realDuration;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }


}