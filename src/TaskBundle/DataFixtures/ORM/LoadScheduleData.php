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
        $schedule->setBeginTime(new \DateTime('-12 hour'));
        $schedule->setDescription('Легкий непревозмогательный день');
        $schedule->addPeriod($this->getReference('period1'));
        $schedule->setUser($this->getReference('fixt_user'));
        $schedule->setDate(new \DateTime('-4 day'));
        $this->setReference('schedule1', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setBeginTime(new \DateTime('-11 hour'));
        $schedule->setDate(new \DateTime('-5 day'));
        $schedule->setDescription('Трудный превозмогательный день 2');
        $schedule->addPeriod($this->getReference('period2'));
        $schedule->setUser($this->getReference('fixt_user'));
        $this->setReference('schedule2', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setBeginTime(new \DateTime('-10 hour'));
        $schedule->setDescription('Ужасный превозмогательный день 3');
        $schedule->setUser($this->getReference('fixt_user'));
        $schedule->setDate(new \DateTime('-3 day'));
        $schedule->addPeriod($this->getReference('period3'));
        $this->setReference('schedule3', $schedule);
        $manager->persist($schedule);

        $schedule = new Schedule();
        $schedule->setBeginTime(new \DateTime('-13 hour'));
        $schedule->setDescription('Невероятный непревозмогательный день 4');
        $schedule->setUser($this->getReference('fixt_user'));
        $schedule->setDate(new \DateTime('-2 day'));
        $schedule->addPeriod($this->getReference('period4'));
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
        return 5;
    }
}