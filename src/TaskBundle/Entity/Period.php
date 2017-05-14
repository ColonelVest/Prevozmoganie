<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Table(name="periods")
 * @ORM\Entity(repositoryClass="PeriodRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Period extends BaseEntity implements UserReferable
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

    use SoftDeleteableEntity;

    /**
     * @var string
     * Gedmo\Versioned
     * @ORM\Column(type="string")
     * @Groups({"full", "concise", "nested"})
     */
    private $description;

    /**
     * @var Task
     * @ORM\OneToOne(targetEntity="TaskBundle\Entity\TaskEntry", mappedBy="period")
     * @Groups({"full"})
     * @Normal\Entity(className="TaskBundle\Entity\TaskEntry")
     */
    private $taskEntry;

    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     * @Groups({"full", "concise", "nested"})
     * @Normal\DateTime(type="time")
     */
    private $begin;

    /**
     * @var \DateTime
     * @Groups({"full", "concise", "nested"})
     * @ORM\Column(type="time")
     * @Assert\NotNull()
     * @Normal\DateTime(type="time")
     */
    private $end;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     * @Groups({"full", "concise", "nested"})
     * @Normal\DateTime(type="date")
     */
    private $date;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Period
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Period
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
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
    public function getTaskEntry() {
        return $this->taskEntry;
    }

    /**
     * @param TaskEntry $taskEntry
     * @return Period
     */
    public function setTaskEntry($taskEntry) {
        $this->taskEntry = $taskEntry;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @param mixed $begin
     * @return Period
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     * @return Period
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

}