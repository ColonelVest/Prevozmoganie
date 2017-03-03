<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;

class TaskHandler extends EntityHandler
{
    protected $notExistsMessage = ErrorMessages::REQUESTED_TASK_NOT_EXISTS;

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Task');
    }
}