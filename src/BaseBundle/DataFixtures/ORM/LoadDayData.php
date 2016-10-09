<?php

namespace BaseBundle\DataFixtures\ORM;

use BaseBundle\Entity\Day;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadDayData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $day = new Day();
        $day->setDate(new \DateTime());
        $day->setUser($this->getReference('fixt_user'));
        $manager->persist($day);
        $this->setReference('day1', $day);

        $day = new Day();
        $day->setDate(new \DateTime('- 1 hour'));
        $day->setUser($this->getReference('fixt_user'));
        $manager->persist($day);
        $this->setReference('day2', $day);

        $day = new Day();
        $day->setDate(new \DateTime('+1 day'));
        $day->setUser($this->getReference('fixt_user2'));
        $manager->persist($day);
        $this->setReference('day3', $day);

        $day = new Day();
        $day->setDate(new \DateTime('-1 day'));
        $day->setUser($this->getReference('fixt_user2'));
        $manager->persist($day);
        $this->setReference('day4', $day);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder() {
        return 2;
    }
}