<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02/07/2017
 * Time: 02:31
 */

namespace StoreBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity()
 * @ORM\Table()
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Item extends BaseEntity
{
    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full", "nested"})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Choice(callback="getDimensionsList")
     * @Groups({"concise", "full", "nested"})
     */
    private $dimension;

    /**
     * @var ItemCategory
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\ItemCategory")
     * @Normal\Entity(className="StoreBundle\Entity\ItemCategory")
     * @Groups({"concise", "full", "nested"})
     */
    private $category;

    /**
     * @return ItemCategory
     */
    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    /**
     * @param ItemCategory $category
     * @return Item
     */
    public function setCategory(ItemCategory $category): Item
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    /**
     * @param string $dimension
     * @return Item
     */
    public function setDimension(string $dimension): Item
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Item
     */
    public function setTitle(string $title): Item
    {
        $this->title = $title;

        return $this;
    }

    public static function getDimensionsList() {
        return [
            'кг', 'г', 'шт', 'л', 'm3', 'уп.', 'бут.'
        ];
    }
}