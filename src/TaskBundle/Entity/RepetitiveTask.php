<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\RepetitiveInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class RepetitiveTask implements UserReferable, RepetitiveInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $beginTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var \DateTime
     */
    protected $beginDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var array
     */
    private $daysOfWeek = [];

    /**
     * @var number
     */
    private $weekFrequency;

    /**
     * @var bool
     */
    private $newTasksCreate = false;

    /**
     * @var int
     */
    private $daysBeforeDeadline;

    /**
     * @var User
     */
    private $user;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return RepetitiveTask
     */
    public function setTitle(string $title): RepetitiveTask
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return RepetitiveTask
     */
    public function setDescription(string $description): RepetitiveTask
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDaysBeforeDeadline()
    {
        return $this->daysBeforeDeadline;
    }

    /**
     * @param mixed $daysBeforeDeadline
     * @return RepetitiveTask
     */
    public function setDaysBeforeDeadline($daysBeforeDeadline)
    {
        $this->daysBeforeDeadline = $daysBeforeDeadline;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNewTasksCreate(): ?bool
    {
        return $this->newTasksCreate;
    }

    /**
     * @param bool $newTasksCreate
     * @return RepetitiveTask
     */
    public function setNewTasksCreate(bool $newTasksCreate): RepetitiveTask
    {
        $this->newTasksCreate = $newTasksCreate;

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
     * @return RepetitiveTask
     */
    public function setBeginTime(?\DateTime $beginTime): RepetitiveTask
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
     * @return RepetitiveTask
     */
    public function setEndTime(?\DateTime $endTime): RepetitiveTask
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate(): ?\DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     * @return RepetitiveTask
     */
    public function setBeginDate(\DateTime $beginDate): RepetitiveTask
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return RepetitiveTask
     */
    public function setEndDate(\DateTime $endDate): RepetitiveTask
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return array
     */
    public function getDaysOfWeek(): ?array
    {
        return $this->daysOfWeek;
    }

    /**
     * @param array $daysOfWeek
     * @return RepetitiveTask
     */
    public function setDaysOfWeek(array $daysOfWeek): RepetitiveTask
    {
        $this->daysOfWeek = $daysOfWeek;

        return $this;
    }

    public function addDayOfWeek($dayOfWeek)
    {
        $this->daysOfWeek[] = $dayOfWeek;

        return $this;
    }

    /**
     * @return int|null|number
     */
    public function getWeekFrequency() : ?int
    {
        return $this->weekFrequency;
    }

    /**
     * @param number $weekFrequency
     * @return RepetitiveTask
     */
    public function setWeekFrequency($weekFrequency): RepetitiveTask
    {
        $this->weekFrequency = $weekFrequency;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return RepetitiveTask
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}