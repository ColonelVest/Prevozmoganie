<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="BaseBundle\Entity\DayRepository")
 * @ORM\Table(name="days")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)"
 * @Gedmo\Loggable
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
     * @Gedmo\Versioned()
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $dayBegin;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $dayEnd;

    /**
     * @return \DateTime
     */
    public function getDayBegin(): ?\DateTime
    {
        return $this->dayBegin;
    }

    /**
     * @param \DateTime $dayBegin
     * @return Day
     */
    public function setDayBegin(\DateTime $dayBegin): Day
    {
        $this->dayBegin = $dayBegin;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDayEnd(): ?\DateTime
    {
        return $this->dayEnd;
    }

    /**
     * @param \DateTime $dayEnd
     * @return Day
     */
    public function setDayEnd(\DateTime $dayEnd): Day
    {
        $this->dayEnd = $dayEnd;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Day
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }
}