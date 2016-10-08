<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DayRepository extends EntityRepository
{
    public function fetchOrCreate(\DateTime $date, User $user)
    {
        $entityManager = $this->getEntityManager();
        $day = $this->findOneBy(['date' => $date]);
        if (!isset($day)) {
            $day = new Day();
            $day->setUser($user);
            $day->setDate($date);
            $entityManager->persist($day);
            $entityManager->flush($day);
        }
        return $day;
    }
}
