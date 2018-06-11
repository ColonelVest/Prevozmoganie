<?php

namespace StoreBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use BaseBundle\Entity\UserReferableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use BaseBundle\Lib\Serialization\Annotation\Normal;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)"
 * @Gedmo\Loggable
 */
class Receipt extends BaseEntity implements UserReferable
{
    use UserReferableTrait;
    use SoftDeleteableEntity;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Groups({"concise", "full", "nested"})
     */
    private $totalSum;

    /**
     * @var BuyItem[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="StoreBundle\Entity\BuyItem", mappedBy="receipt")
     * @Normal\Entity(className="StoreBundle\Entity\BuyItem", isMultiple=true)
     * @Groups({"concise", "full", "nested"})
     */
    private $items;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups({"concise", "full", "nested"})
     * @Normal\DateTime(type="datetime")
     */
    private $dateTime;

    /**
     * @var int
     * @ORM\Column(type="bigint")
     * @Groups({"concise", "full", "nested"})
     */
    private $fiscalNumber;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getTotalSum(): ?float
    {
        return $this->totalSum;
    }

    /**
     * @param float $totalSum
     * @return Receipt
     */
    public function setTotalSum(float $totalSum): Receipt
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    /**
     * @return ArrayCollection|BuyItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection|BuyItem[] $items
     * @return Receipt
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param BuyItem $buyItem
     * @return Receipt
     */
    public function addItem(BuyItem $buyItem)
    {
        $this->items->add($buyItem);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return Receipt
     */
    public function setDateTime(\DateTime $dateTime): Receipt
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalNumber()
    {
        return $this->fiscalNumber;
    }

    /**
     * @param int $fiscalNumber
     * @return Receipt
     */
    public function setFiscalNumber(int $fiscalNumber): Receipt
    {
        $this->fiscalNumber = $fiscalNumber;

        return $this;
    }
}