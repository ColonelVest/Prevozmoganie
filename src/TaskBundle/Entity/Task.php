<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tasks")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)"
 * @Gedmo\Loggable()
 */
class Task extends BaseEntity
{

    /**
     * Hook softdeleteable behavior
     * deletedAt field
     */
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Versioned
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Gedmo\Versioned
     */
    private $body;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $children;

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
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
    }
}