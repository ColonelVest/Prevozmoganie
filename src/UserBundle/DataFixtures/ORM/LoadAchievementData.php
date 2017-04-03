<?php

namespace UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use UserBundle\Entity\Achievement;

class LoadAchievementData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const ACHIEVEMENT_TYPES = [
        'for_1_day' => 'P1D',
        'for_3_days' => 'P3D',
        'for_week' => 'P1W',
        'for_month' => 'P1M',
        'for_3_month' => 'P3M',
        'for_half_year' => 'P6M',
        'for_year' => 'P1Y'
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //TODO: Добавить проверку на наличие таковой ачивки по названию
        foreach (self::ACHIEVEMENT_TYPES as $name => $dateIntervalString) {
            $achievement = (new Achievement())
                ->setName($name)
                ->setDateInterval($dateIntervalString)
                ->setClassType('task');
            ;

            $manager->persist($achievement);
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
        return 9999;
    }
}