<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02/07/2017
 * Time: 20:45
 */

namespace StoreBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ItemCategory
 * @package StoreBundle\Entity
 * @ORM\Entity()
 * @ORM\Table()
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ItemCategory extends BaseEntity
{
    const UNDEFINED_CATEGORY_TITLE = 'undefined';
    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "nested", "full"})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "nested", "full"})
     */
    private $icon = 'shopping_cart';

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ItemCategory
     */
    public function setTitle(string $title): ItemCategory
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return ItemCategory
     */
    public function setIcon(string $icon): ItemCategory
    {
        $this->icon = $icon;

        return $this;
    }
}