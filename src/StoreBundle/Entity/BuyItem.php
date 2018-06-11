<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02/07/2017
 * Time: 02:41
 */

namespace StoreBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use BaseBundle\Lib\Serialization\Annotation\Normal;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="BuyItemRepository")
 * @ORM\Table()
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class BuyItem extends BaseEntity implements UserReferable
{
    use SoftDeleteableEntity;

    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Item")
     * @Groups({"concise", "nested", "full"})
     * @Normal\Entity(className="StoreBundle\Entity\Item")
     */
    private $item;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Groups({"concise", "nested", "full"})
     * @Assert\NotBlank()
     */
    private $quantity;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var bool
     * @Groups({"concise", "nested", "full"})
     * @ORM\Column(type="boolean")
     */
    private $isBought = false;

    /**
     * @var Receipt
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Receipt", inversedBy="items")
     */
    private $receipt;

    /**
     * @return bool
     */
    public function isBought(): ?bool
    {
        return $this->isBought;
    }

    /**
     * @param bool $isBought
     * @return BuyItem
     */
    public function setIsBought(bool $isBought): BuyItem
    {
        $this->isBought = $isBought;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return BuyItem
     */
    public function setItem(Item $item): BuyItem
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return BuyItem
     */
    public function setQuantity(float $quantity): BuyItem
    {
        $this->quantity = $quantity;

        return $this;
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
     * @return BuyItem
     */
    public function setUser(User $user): BuyItem
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Receipt
     */
    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    /**
     * @param Receipt $receipt
     * @return BuyItem
     */
    public function setReceipt(Receipt $receipt): BuyItem
    {
        $this->receipt = $receipt;

        return $this;
    }
}