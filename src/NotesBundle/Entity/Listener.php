<?php

namespace NotesBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="listeners")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * Class Listener
 * @package NotesBundle\Entity
 */
class Listener extends BaseEntity
{
    use SoftDeleteableEntity;

    use BlameableEntity;

    /**
     * @var array
     * @ORM\Column(name="actions", type="array")
     * @Groups({"full", "concise"})
     */
    private $actions = [];

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotNull()
     * @Groups({"full", "concise"})
     */
    private $event;

    /**
     * @return array
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @param array $actions
     * @return Listener
     */
    public function setActions(array $actions): Listener
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @return string
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string $event
     * @return Listener
     */
    public function setEvent(string $event): Listener
    {
        $this->event = $event;

        return $this;
    }
}