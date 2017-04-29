<?php

namespace FoodBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * Class MealEntryRepository
 * @package FoodBundle\Entity
 */
class MealEntryRepository extends EntityRepository
{
    //TODO: Переделать в поиск по критерию
    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     * @param User $user
     * @param $mealType
     * @return mixed
     */
    public function getByCriteria(\DateTime $begin, \DateTime $end, User $user, $mealType)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->from(MealEntry::class, 'me')
            ->select('me')
            ->where('me.date BETWEEN :begin AND :end')
            ->setParameter('begin', $begin)
            ->setParameter('end', $end)
            ->andWhere('me.user = :user')
            ->setParameter(':user', $user)
            ->leftJoin('me.meal', 'mt')
            ->andWhere('mt.mealType = :mealType')
            ->setParameter('mealType', $mealType);

        return $qb->getQuery()->execute();
    }
}