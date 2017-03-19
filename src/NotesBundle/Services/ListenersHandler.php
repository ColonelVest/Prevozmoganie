<?php

namespace NotesBundle\Services;


use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class ListenersHandler extends EntityHandler
{
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('NotesBundle:Listener');
    }
}