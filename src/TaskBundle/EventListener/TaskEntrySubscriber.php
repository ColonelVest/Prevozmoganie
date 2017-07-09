<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 08/07/2017
 * Time: 15:59
 */

namespace TaskBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use TaskBundle\Entity\TaskEntry;

class TaskEntrySubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate => 'preUpdate'
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $taskEntry = $args->getEntity();
        if ($taskEntry instanceof TaskEntry) {

        }
    }
}