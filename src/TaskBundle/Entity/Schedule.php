<?php

namespace TaskBundle\Entity;

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
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)"
 * @ORM\Table(name="schedules")
 * @Gedmo\Loggable
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
     * @ORM\ManyToMany(targetEntity="Period")
     * @ORM\JoinTable(name="schedule_periods",
     *      joinColumns={@ORM\JoinColumn(name="schedule_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="period_id", referencedColumnName="id", unique=true)})
     */
    private $periods;

    /**
     * @ORM\Column()
     * @Gedmo\Versioned()
     * @Assert\NotNull()
     */
    private $description;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotNull(message = "12")
     */
    private $beginTime;

    /**
     * @ORM\Column(type="date", unique=true, nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getPeriods() {
        return $this->periods;
    }

    /**
     * @param $period
     * @return Schedule
     */
    public function addPeriod($period) {
        $this->periods[] = $period;

        return $this;
    }

    /**
     * @param Period $period
     * @return Schedule
     */
    public function removePeriod(Period $period)
    {
        $this->periods->removeElement($period);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Schedule
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBeginTime() {
        return $this->beginTime;
    }

    /**
     * @param mixed $beginTime
     * @return Schedule
     */
    public function setBeginTime($beginTime) {
        $this->beginTime = $beginTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Schedule
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Schedule
     */
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

}