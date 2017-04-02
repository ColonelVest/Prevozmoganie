<?php

namespace UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadAchievementData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const ACHIEVEMENT_TYPES = [
        'for_1_day' => '- 1 days',
        'for_3_days' => '- 3 days',
        'for_week' => '- 1 week',
        'for_month' => '- 1 month',
        'for_3_month' => '- 3 month',
        'for_half_year' => '- 6 month',
        'for_year' => '- 1 year'
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 9999;
    }
}