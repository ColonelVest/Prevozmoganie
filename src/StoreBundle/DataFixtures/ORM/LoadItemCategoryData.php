<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 02/07/2017
 * Time: 20:50
 */

namespace StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use StoreBundle\Entity\ItemCategory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadItemCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const ITEM_CATEGORY_DATA = [
        ['title' => 'food', 'icon' => 'restaurant'],
        ['title' => 'medicines', 'icon' => 'local_hospital'],
        ['title' => 'other', 'icon' => 'shopping_cart'],
        ['title' => 'technical', 'icon' => 'computer'],
        ['title' => 'household good', 'icon' => 'home']
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::ITEM_CATEGORY_DATA as $categoryData) {
            $category = $manager
                ->getRepository('StoreBundle:ItemCategory')
                ->findOneBy(['title' => $categoryData['title']]);
            if (is_null($category)) {
                $category = new ItemCategory();
                $manager->persist($category);
                $this->setReference($categoryData['title'].'_item_category', $category);
            }
            $category
                ->setIcon($categoryData['icon'])
                ->setTitle($categoryData['title']);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }
}