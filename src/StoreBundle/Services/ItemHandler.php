<?php

namespace StoreBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;
use StoreBundle\Entity\Item;
use StoreBundle\Entity\ItemCategory;

class ItemHandler extends EntityHandler
{
    /**
     * @param string $itemName
     * @param ItemCategory|null $category
     * @param string|null $dimension
     * @return Item
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

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('StoreBundle:Item');
    }
}