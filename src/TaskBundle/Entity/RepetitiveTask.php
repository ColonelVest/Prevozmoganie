<?php

namespace TaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class RepetitiveTask extends BaseTask
{
    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $begin;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $end;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"concise"})
     */
    private $frequency;

    /**
     * @return \DateTime
     */
    public function getBegin(): ?\DateTime
    {
        return $this->begin;
    }

    /**
     * @param \DateTime $begin
     * @return RepetitiveTask
     */
    public function setBegin(\DateTime $begin): RepetitiveTask
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
     * @return RepetitiveTask
     */
    public function setEnd(\DateTime $end): RepetitiveTask
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return int
     */
    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    /**
     * @param int $frequency
     * @return RepetitiveTask
     */
    public function setFrequency(int $frequency): RepetitiveTask
    {
        $this->frequency = $frequency;

        return $this;
    }
}