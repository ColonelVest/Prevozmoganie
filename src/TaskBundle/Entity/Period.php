<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use TaskBundle\Entity\Task;

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
    private $realDuration = 0;

    /**
     * @var string
     * Gedmo\Versioned
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $internalNumber = 0;

    /**
     * @ORM\OneToOne(targetEntity="Task", mappedBy="period")
     */
    private $task;

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
    public function setRealDuration($realDuration)
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
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTask() {
        return $this->task;
    }

    /**
     * @param mixed $task
     */
    public function setTask($task) {
        $this->task = $task;
    }


}