<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 11/06/2018
 * Time: 12:45
 */

namespace BaseBundle\Entity;

use UserBundle\Entity\User;

trait UserReferableTrait
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return static
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}