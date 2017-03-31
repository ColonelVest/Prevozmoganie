<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tasks")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Task extends BaseEntity
{
    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full"})
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full", "concise"})
     */
    private $description;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * @ORM\OneToOne(targetEntity="Period", inversedBy="task")
     *
     */
    private $period;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"full", "concise"})
     */
    private $isCompleted = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"full", "concise"})
     */
    private $date;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"full", "concise"})
     */
    private $beginTime;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"full", "concise"})
     */
    private $endTime;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"full", "concise"})
     */
    private $deadline;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return \DateTime
     */
    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }

    /**
     * @param \DateTime $deadline
     * @return Task
     */
    public function setDeadline(?\DateTime $deadline): Task
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBeginTime(): ?\DateTime
    {
        return $this->beginTime;
    }

    /**
     * @param \DateTime $beginTime
     * @return Task
     */
    public function setBeginTime(?\DateTime $beginTime): Task
    {
        $this->beginTime = $beginTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     * @return Task
     */
    public function setEndTime(?\DateTime $endTime): Task
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param mixed $children
     * @return Task
     */
    public function setChildren($children) {
        $this->children = $children;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * @param mixed $period
     * @return Task
     */
    public function setPeriod($period) {
        $this->period = $period;
        return $this;
    }

    public function removeChild(Task $task)
    {
        $task->setParent(null);

        return $this;
    }

    public function addChild(Task $task)
    {
        $task->setParent($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildTasks()
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return bool
     */
    public function isIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     * @return Task
     */
    public function setIsCompleted(bool $isCompleted): Task
    {
        $this->isCompleted = $isCompleted;

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
     * @return Task
     */
    public function setDate(?\DateTime $date): Task
    {
        $this->date = $date;

        return $this;
    }

}