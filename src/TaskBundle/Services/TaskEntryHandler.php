<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 13.05.17
 * Time: 21:28
 */

namespace TaskBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;
use TaskBundle\Entity\TaskEntry;

class TaskEntryHandler extends EntityHandler
{
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:TaskEntry');
    }
}