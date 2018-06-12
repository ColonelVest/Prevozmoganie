<?php

namespace StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BuyItemRepository extends EntityRepository
{
    /**
     * @param $title
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByTitleWithItem($title)
    {
        /** @var BuyItem $existedBuyItem */
        return $this->createQueryBuilder('bi')
            ->andWhere('bi.title = :title')
            ->andWhere('bi.item IS NOT NULL')
            ->setParameter('title', $title)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
