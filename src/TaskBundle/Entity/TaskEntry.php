<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 09.05.17
 * Time: 22:39
 */

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\DateCondition;
use BaseBundle\Entity\UserReferable;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity(repositoryClass="TaskBundle\Entity\TaskEntryRepository")
 * @ORM\Table(name="task_entries")
 * Class TaskEntry
 * @package TaskBundle\Entity
 */
class TaskEntry extends BaseEntity implements UserReferable
{
    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Normal\DateTime()
     * @Groups({"full", "concise", "nested"})
     */
    protected $date;

//    /**
//     * @ORM\OneToOne(targetEntity="Period", inversedBy="taskEntry")
//     * @Normal\Entity(className="TaskBundle\Entity\Period")
//     */
//    protected $period;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"full", "concise", "nested"})
     */
    protected $isCompleted = false;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="TaskBundle\Entity\Task", inversedBy="entries")
     * @Normal\Entity(className="TaskBundle\Entity\Task")
     * @Groups({"full", "concise", "nested"})
     */
    protected $task;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Normal\DateTime()
     * @Groups({"full", "concise", "nested"})
     */
    protected $deadLine;

    /**
     * @var DateCondition
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\DateCondition")
     * @Normal\Entity(className="BaseBundle\Entity\DateCondition")
     * @Groups({"full"})
     */
    protected $dateCondition;

    /**
     * @return DateCondition
     */
    public function getDateCondition(): ?DateCondition
    {
        return $this->dateCondition;
    }

    /**
     * @param DateCondition $dateCondition
     * @return TaskEntry
     */
    public function setDateCondition(DateCondition $dateCondition): TaskEntry
    {
        $this->dateCondition = $dateCondition;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeadLine(): ?\DateTime
    {
        return $this->deadLine;
    }

    /**
     * @param \DateTime $deadLine
     * @return TaskEntry
     */
    public function setDeadLine(?\DateTime $deadLine): TaskEntry
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return TaskEntry
     */
    public function setDate(?\DateTime $date): TaskEntry
    {
        $this->date = $date;

        return $this;
    }

//    /**
//     * @return mixed
//     */
//    public function getPeriod()
//    {
//        return $this->period;
//    }
//
//    /**
//     * @param mixed $period
//     * @return TaskEntry
//     */
//    public function setPeriod($period)
//    {
//        $this->period = $period;
//
//        return $this;
//    }

    /**
     * @return bool
     */
    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return TaskEntry
     */
    public function setIsCompleted(bool $isCompleted): TaskEntry
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return Task
     */
    public function getTask(): ?Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     * @return TaskEntry
     */
    public function setTask(Task $task): TaskEntry
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return TaskEntry
     */
    public function setUser(User $user): TaskEntry
    {
        $this->user = $user;

        return $this;
    }
}