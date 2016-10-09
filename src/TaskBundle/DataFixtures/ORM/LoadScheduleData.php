<?php

namespace TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Doctrine\Common\Persistence\ObjectManager;
use TaskBundle\Entity\Schedule;

class LoadScheduleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $schedule = new Schedule();
        $schedule->setStartTime(new \DateTime('-12 hour'));
        $schedule->setDay($this->getReference('day1'));
        $schedule->setDescription('Трудный превозмогательный день');
        $this->setReference('schedule1', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setStartTime(new \DateTime('-11 hour'));
        $schedule->setDay($this->getReference('day2'));
        $schedule->setDescription('Трудный превозмогательный день 2');
        $this->setReference('schedule2', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setStartTime(new \DateTime('-10 hour'));
        $schedule->setDay($this->getReference('day3'));
        $schedule->setDescription('Трудный превозмогательный день 3');
        $this->setReference('schedule3', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setStartTime(new \DateTime('-13 hour'));
        $schedule->setDay($this->getReference('day4'));
        $schedule->setDescription('Трудный превозмогательный день 4');
        $this->setReference('schedule4', $schedule);
        $manager->persist($schedule);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}