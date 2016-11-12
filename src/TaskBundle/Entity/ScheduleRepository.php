<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;
use BaseBundle\Entity\User;

class ScheduleRepository extends EntityRepository
{
    public function fetchOrCreate(\DateTime $date, User $user)
    {
        $entityManager = $this->getEntityManager();
        $day = $this->findOneBy(['date' => $date]);
        if (!isset($day)) {
            $schedule = new Schedule();
            $schedule->setUser($user);
            $schedule->setDate($date);
            $entityManager->persist($day);
            $entityManager->flush($day);
        }
        return $day;
    }
}
