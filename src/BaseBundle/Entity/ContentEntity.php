<?php

namespace BaseBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

trait ContentEntity
{
    /**
     * @ORM\Column(type="string")
     * @Gedmo\Versioned
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Gedmo\Versioned
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
}