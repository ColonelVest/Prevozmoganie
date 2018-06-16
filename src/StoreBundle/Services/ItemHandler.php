<?php

namespace StoreBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use StoreBundle\Entity\Item;
use StoreBundle\Entity\ItemCategory;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ItemHandler extends EntityHandler
{
    private $buyItemHandler;

    public function __construct(EntityManager $em,
        RecursiveValidator $validator,
        BuyItemHandler $buyItemHandler
    )
    {
        parent::__construct($em, $validator);
        $this->buyItemHandler = $buyItemHandler;
    }

    /**
     * @param string $itemName
     * @param ItemCategory|null $category
     * @param string|null $dimension
     * @return Item
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findOrCreate(string $itemName, ItemCategory $category = null, string $dimension = null)
    {
        $item = $this->getRepository()->findOneBy(['title' => $itemName]);
        if (is_null($item)) {
            if (is_null($category)) {
                $category = $this->em
                    ->getRepository('StoreBundle:ItemCategory')
                    ->findOneBy(['title' => ItemCategory::UNDEFINED_CATEGORY_TITLE]);
            }

            $item = (new Item())
                ->setTitle($itemName)
                ->setCategory($category)
                ->setDimension($dimension ?? '?');

            $itemCreationResult = $this->create($item, false);
            if (!$itemCreationResult->getIsSuccess()) {
                throw new \RuntimeException('Default item by title is not valid!');
            }
        }

        return $item;
    }

    /**
     * @param Item $supersedeItem
     * @param Item $item
     * @return \BaseBundle\Models\Result
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function supersedeItem(Item $supersedeItem, Item $item)
    {
        $buyItems = $this->em
            ->getRepository('StoreBundle:BuyItem')
            ->findBy(['item' => $supersedeItem]);

        foreach ($buyItems as $buyItem) {
            $buyItem->setItem($item);
            $this->buyItemHandler->edit($buyItem, false);
        }

        $this->em->flush();

        return $this->remove($supersedeItem);
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('StoreBundle:Item');
    }
}