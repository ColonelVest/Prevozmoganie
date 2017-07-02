<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02/07/2017
 * Time: 09:42
 */

namespace StoreBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use BaseBundle\Models\HaveEntriesInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use BaseBundle\Lib\Serialization\Annotation\Normal;
use UserBundle\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\Table()
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ItemEntry extends BaseEntity implements UserReferable
{
    use SoftDeleteableEntity;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Item")
     * @Normal\Entity(className="StoreBundle\Entity\Item")
     * @Groups({"concise", "nested", "full"})
     */
    private $item;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Groups({"concise", "nested", "full"})
     */
    private $quantity;

    /**
     * @return Item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return ItemEntry
     */
    public function setItem(Item $item): ItemEntry
    {
        $this->item = $item;

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
     * @return ItemEntry
     */
    public function setUser(User $user): ItemEntry
    {
        $this->user = $user;

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
     * @return ItemEntry
     */
    public function setQuantity(float $quantity): ItemEntry
    {
        $this->quantity = $quantity;

        return $this;
    }
}