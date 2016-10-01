<?php

namespace BaseBundle\Entity;



use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="days")
 */
class Day extends BaseEntity
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

    /**
     * @ORM\OneToOne(targetEntity="ScheduleBundle\Entity\Schedule")
     */
    private $schedule;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSchedule() {
        return $this->schedule;
    }

    /**
     * @param mixed $schedule
     */
    public function setSchedule($schedule) {
        $this->schedule = $schedule;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date) {
        $this->date = $date;
    }
}