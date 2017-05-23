<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 20.05.17
 * Time: 20:07
 */

namespace BaseBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
* @ORM\Entity()
* @ORM\Table(name="date_conditions")
* @Gedmo\Loggable()
* @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
*/
class DateCondition extends BaseEntity
{
    use SoftDeleteableEntity;

    use TimestampableEntity;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Normal\DateTime()
     */
    protected $beginDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Normal\DateTime()
     */
    protected $endDate;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $daysOfWeek = [];

    /**
     * @var number
     * @ORM\Column(type="integer")
     */
    private $weekFrequency = 1;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $newTasksCreate = false;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $daysBeforeDeadline;

    /**
     * @return \DateTime
     */
    public function getBeginDate(): ?\DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     * @return DateCondition
     */
    public function setBeginDate(\DateTime $beginDate): DateCondition
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
     * @return DateCondition
     */
    public function setEndDate(\DateTime $endDate): DateCondition
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return array
     */
    public function getDaysOfWeek(): array
    {
        return $this->daysOfWeek;
    }

    /**
     * @param array $daysOfWeek
     * @return DateCondition
     */
    public function setDaysOfWeek(array $daysOfWeek): DateCondition
    {
        $this->daysOfWeek = $daysOfWeek;

        return $this;
    }

    /**
     * @return number
     */
    public function getWeekFrequency()
    {
        return $this->weekFrequency;
    }

    /**
     * @param int $weekFrequency
     * @return DateCondition
     */
    public function setWeekFrequency(int $weekFrequency): DateCondition
    {
        $this->weekFrequency = $weekFrequency;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNewTasksCreate()
    {
        return $this->newTasksCreate;
    }

    /**
     * @param bool $newTasksCreate
     * @return DateCondition
     */
    public function setNewTasksCreate(bool $newTasksCreate): DateCondition
    {
        $this->newTasksCreate = $newTasksCreate;

        return $this;
    }

    /**
     * @return int
     */
    public function getDaysBeforeDeadline()
    {
        return $this->daysBeforeDeadline;
    }

    /**
     * @param int $daysBeforeDeadline
     * @return DateCondition
     */
    public function setDaysBeforeDeadline(int $daysBeforeDeadline): DateCondition
    {
        $this->daysBeforeDeadline = $daysBeforeDeadline;

        return $this;
    }

}