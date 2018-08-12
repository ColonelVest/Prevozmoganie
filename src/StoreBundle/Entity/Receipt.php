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
 * @ORM\Entity(repositoryClass="ReceiptRepository")
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

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"concise", "full", "nested"})
     */
    private $fiscalDocumentNumber;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"concise", "full", "nested"})
     */
    private $fpd;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"full", "nested"})
     */
    private $storeInn;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full", "nested"})
     */
    private $storeName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full", "nested"})
     */
    private $storeAddress;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full", "nested"})
     */
    private $cashier;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $cashTotalSum;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $ecashTotalSum;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getFiscalDocumentNumber(): ?int
    {
        return $this->fiscalDocumentNumber;
    }

    /**
     * @param int $fiscalDocumentNumber
     * @return Receipt
     */
    public function setFiscalDocumentNumber(int $fiscalDocumentNumber): Receipt
    {
        $this->fiscalDocumentNumber = $fiscalDocumentNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getFpd(): ?int
    {
        return $this->fpd;
    }

    /**
     * @param int $fpd
     * @return Receipt
     */
    public function setFpd(int $fpd): Receipt
    {
        $this->fpd = $fpd;

        return $this;
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

    /**
     * @return string
     */
    public function getStoreInn(): ?string
    {
        return $this->storeInn;
    }

    /**
     * @param string $storeInn
     * @return Receipt
     */
    public function setStoreInn(string $storeInn): Receipt
    {
        $this->storeInn = $storeInn;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoreName(): ?string
    {
        return $this->storeName;
    }

    /**
     * @param string $storeName
     * @return Receipt
     */
    public function setStoreName(string $storeName): Receipt
    {
        $this->storeName = $storeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoreAddress(): ?string
    {
        return $this->storeAddress;
    }

    /**
     * @param string $storeAddress
     * @return Receipt
     */
    public function setStoreAddress(string $storeAddress): Receipt
    {
        $this->storeAddress = $storeAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getCashier(): ?string
    {
        return $this->cashier;
    }

    /**
     * @param string $cashier
     * @return Receipt
     */
    public function setCashier(string $cashier): Receipt
    {
        $this->cashier = $cashier;

        return $this;
    }

    /**
     * @return float
     */
    public function getCashTotalSum(): ?float
    {
        return $this->cashTotalSum;
    }

    /**
     * @param float $cashTotalSum
     * @return Receipt
     */
    public function setCashTotalSum(float $cashTotalSum): Receipt
    {
        $this->cashTotalSum = $cashTotalSum;

        return $this;
    }

    /**
     * @return float
     */
    public function getEcashTotalSum(): ?float
    {
        return $this->ecashTotalSum;
    }

    /**
     * @param float $ecashTotalSum
     * @return Receipt
     */
    public function setEcashTotalSum(float $ecashTotalSum): Receipt
    {
        $this->ecashTotalSum = $ecashTotalSum;

        return $this;
    }
}