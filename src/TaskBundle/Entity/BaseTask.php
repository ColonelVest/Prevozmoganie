<?php

namespace TaskBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class BaseTask extends BaseEntity
{
    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full"})
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"full", "concise"})
     */
    private $description;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BaseTask
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return BaseTask
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}