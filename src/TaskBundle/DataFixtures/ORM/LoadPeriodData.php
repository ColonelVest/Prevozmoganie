<?php

namespace TaskBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TaskBundle\Entity\Period;

class LoadPeriodData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->periods as $index => $item) {
            $period = new Period();
//            $period->setTaskEntry($this->getReference('task'.$index));
            $period->setUser($this->getReference('fixt_admin'));
            $period->setCreatedBy($this->getReference('fixt_admin'));
            $period->setCreatedAt(new \DateTime());
            $period->setDate(new \DateTime($item[0] . ' day'));
            $period->setBegin(\DateTime::createFromFormat('H:i', $item[1]));
            $period->setEnd(\DateTime::createFromFormat('H:i', $item[3]));
            $period->setDescription($item[2]);
            $manager->persist($period);
            $this->addReference('period'.$index, $period);
        }
        $manager->flush();
    }

    private $periods = [
        ['-2', '09:00', 'opop', '09:10'],
        ['-1', '09:00', '123df', '09:10'],
        ['+1', '09:00', 'asdf', '09:10'],
        ['+2', '09:00', 'asdf', '09:10'],
        ['-2', '19:00', '34eerw','19:10'],
        ['+2', '19:00', 'qtqregtwer','19:10'],
    ];

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