<?php

namespace UserBundle\Entity;

use BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="achievements")
 * Class Achievement
 * @package UserBundle\Entity
 */
class Achievement extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Achievement
     */
    public function setName(string $name): Achievement
    {
        $this->name = $name;

        return $this;
    }
}