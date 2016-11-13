<?php

namespace TaskBundle\Services;

use Doctrine\ORM\EntityManager;

class Schedule
{
    /** @var  EntityManager $em */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSchedule($dateString)
    {
        //TODO: Добавить проверку на корректность данных
        $date = \DateTime::createFromFormat('dmY', $dateString);

        return $this->em->getRepository('TaskBundle:Schedule')->findOneBy(['date' => $date]);
    }
}