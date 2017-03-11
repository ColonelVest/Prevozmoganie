<?php

namespace ErrorsBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="errors")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Error extends BaseEntity
{
    use TimestampableEntity;

    use BlameableEntity;

    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $body;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $reason;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $solution;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

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

}