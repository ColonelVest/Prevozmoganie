<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class PeriodRepository
 * @package TaskBundle\Entity
 */
class PeriodRepository extends EntityRepository
{
    public function getByDate(\DateTime $date)
    {
        return $this->findBy(['date' => $date]);
    }
}
