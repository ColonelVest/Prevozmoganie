<?php

namespace NotesBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity(repositoryClass="ListenerRepository")
 * @ORM\Table(name="listeners")
 * @Gedmo\Loggable()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * Class Listener
 * @package NotesBundle\Entity
 */
class Listener extends BaseEntity implements UserReferable
{
    use SoftDeleteableEntity;

    use BlameableEntity;

    /**
     * @var array
     * @ORM\Column(name="actions", type="array")
     * @Groups({"full", "concise", "nested"})
     */
    private $actions = [];

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotNull()
     * @Groups({"full", "concise", "nested"})
     */
    private $event;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @Normal\Entity(className="UserBundle\Entity\User")
     */
    private $user;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Listener
    {
        $this->user = $user;

        return $this;
    }
}