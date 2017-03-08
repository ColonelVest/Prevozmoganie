<?php

namespace TaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class RepetitiveTask extends BaseTask
{
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

}