<?php

namespace BaseBundle\Entity;

use UserBundle\Entity\User;

interface UserReferable
{
    public function getUser();
    public function setUser(User $user);
}