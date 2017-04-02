<?php

namespace ErrorsBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use BaseBundle\Entity\UserReferable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="ErrorRepository")
 * @ORM\Table(name="errors")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Error extends BaseEntity implements UserReferable
{
    use TimestampableEntity;

    use BlameableEntity;

    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     */
    private $body;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"concise", "full"})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     */
    private $reason;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     */
    private $solution;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     * @Assert\Choice(callback="getErrorTypes")
     */
    private $type;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"full", "concise"})
     */
    private $isFixed = false;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"full"})
     */
    private $prevention;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Error
     */
    public function setBody(string $body): Error
    {
        $this->body = $body;

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
     * @return Error
     */
    public function setTitle(string $title): Error
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return Error
     */
    public function setReason(?string $reason): Error
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return string
     */
    public function getSolution(): ?string
    {
        return $this->solution;
    }

    /**
     * @param string $solution
     * @return Error
     */
    public function setSolution(?string $solution): Error
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Error
     */
    public function setType(?string $type): Error
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsFixed(): ?bool
    {
        return $this->isFixed;
    }

    /**
     * @param bool $isFixed
     * @return Error
     */
    public function setIsFixed(bool $isFixed): Error
    {
        $this->isFixed = $isFixed;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrevention(): ?string
    {
        return $this->prevention;
    }

    /**
     * @param string $prevention
     * @return Error
     */
    public function setPrevention(string $prevention): Error
    {
        $this->prevention = $prevention;

        return $this;
    }

    public static function getErrorTypes()
    {
        return [
            'typo',
            'algorithmic',
            'forgot'
        ];
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Error
    {
        $this->user = $user;

        return $this;
    }
}