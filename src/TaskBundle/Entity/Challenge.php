<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 15:31
 */

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use BaseBundle\Lib\Serialization\Annotation\Normal;
use UserBundle\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="challenges")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * Class Challenge
 * @package TaskBundle\Entity
 */
class Challenge extends BaseEntity
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Normal\DateTime()
     * @Groups({"full", "concise", "nested"})
     * @Assert\NotNull()
     */
    private $begin;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Normal\DateTime()
     * @Groups({"full", "concise", "nested"})
     * @Assert\NotNull()
     */
    private $end;

    /**
     * @var ArrayCollection|Task[]
     * @ORM\ManyToMany(targetEntity="TaskBundle\Entity\Task")
     * @Normal\Entity(isMultiple=true, className="TaskBundle\Entity\Task")
     * @ORM\JoinTable(name="challenges_tasks",
     *     joinColumns={@ORM\JoinColumn(name="challenge_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")})
     * @Groups({"full", "nested"})
     * @MaxDepth(1)
     */
    private $tasks;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"full", "nested"})
     * @Assert\NotNull()
     */
    private $award;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
     * @return Challenge
     */
    public function setUser(User $user): Challenge
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBegin(): ?\DateTime
    {
        return $this->begin;
    }

    /**
     * @param \DateTime $begin
     * @return Challenge
     */
    public function setBegin(\DateTime $begin): Challenge
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     * @return Challenge
     */
    public function setEnd(\DateTime $end): Challenge
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return ArrayCollection|Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param $tasks
     * @return Challenge
     */
    public function setTasks($tasks)
    {
        foreach ($tasks as $task) {
            $this->tasks->add($task);
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return Challenge
     */
    public function addTask(Task $task)
    {
        $this->tasks->add($task);

        return $this;
    }

    /**
     * @return string
     */
    public function getAward(): ?string
    {
        return $this->award;
    }

    /**
     * @param string $award
     * @return Challenge
     */
    public function setAward(string $award): Challenge
    {
        $this->award = $award;

        return $this;
    }
}