<?php

namespace ScheduleBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ScheduleRepository")
 * @ORM\Table(name="schedules")
 */
class Schedule extends BaseEntity
{
    /**
     * Hook softdeleteable behavior
     * deletedAt field
     */
    use SoftDeleteableEntity;

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

    public function __construct()
    {
        $this->periods = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Period",  mappedBy="day")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $periods;

    /**
     * @ORM\Column()
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="BaseBundle\Entity\Day")
     */
    private $day;

    /**
     * @return mixed
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @ORM\Column(type="time")
     */
    private $startTime;

    /**
     * @param mixed $day
     */
    public function setDay($day) {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }


    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @param Period $period
     * @return $this
     */
    public function addPeriod(Period $period)
    {
        $this->periods[] = $period;

        return $this;
    }

    public function removePeriod(Period $period)
    {
        $this->periods->removeElement($period);
    }

    /**
     * @return mixed
     */
    public function getPeriods() {
        return $this->periods;
    }

}