<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use BaseBundle\Lib\Serialization\Annotation\Normal;

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
     * @Groups({"concise", "full", "nested"})
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full", "concise", "nested"})
     */
    private $description;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="children")
     * @Normal\Entity(className="TaskBundle\Entity\Task")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parent", cascade={"persist", "remove"})
     * @Normal\Entity(className="TaskBundle\Entity\Task", isMultiple=true)
     */
    private $children;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"full", "concise", "nested"})
     * @Normal\DateTime(type="time")
     */
    private $beginTime;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=true)
     * @Groups({"full", "concise", "nested"})
     * @Normal\DateTime(type="time")
     */
    private $endTime;

    /**
     * @var ArrayCollection|TaskEntry[]
     * @ORM\OneToMany(targetEntity="TaskBundle\Entity\TaskEntry", mappedBy="task")
     * @Groups({"full", "concise"})
     * @MaxDepth(1)
     * @Normal\Entity(className="TaskBundle\Entity\TaskEntry", isMultiple=true)
     */
    private $taskEntries;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->taskEntries = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|TaskEntry[]
     */
    public function getTaskEntries()
    {
        return $this->taskEntries;
    }

    /**
     * @param TaskEntry $taskEntry
     * @return Task
     */
    public function addTaskEntry(TaskEntry $taskEntry)
    {
        $this->taskEntries->add($taskEntry);

        return $this;
    }

    /**
     * @param TaskEntry $taskEntry
     * @return Task
     */
    public function removeTaskEntry(TaskEntry $taskEntry)
    {
        $this->taskEntries->remove($taskEntry);

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
}