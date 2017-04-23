<?php

namespace NotesBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity(repositoryClass="NoteRepository")
 * @ORM\Table(name="notes")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 */
class Note extends BaseEntity implements UserReferable
{
    /**
     * Hook softdeleteable behavior
     * deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @Normal\Entity(className="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     * @Assert\Length(max=50, maxMessage="too_long_note_title"))
     * @Gedmo\Versioned
     * @Groups({"concise", "full"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Gedmo\Versioned
     * @Groups({"concise", "full"})
     */
    private $body;

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Note
     */
    public function setUser(User $user) : Note
    {
        $this->user = $user;

        return $this;
    }
}