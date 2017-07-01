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
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full", "nested"})
     * @Assert\Choice(callback="getItemTypes")
     */
    private $type;

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Item
     */
    public function setType(string $type): Item
    {
        $this->type = $type;

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
            'кг', 'г', 'шт', 'л', 'm3', 'уп.'
        ];
    }

    public static function getItemTypes()
    {
        return ['food'];
    }
}