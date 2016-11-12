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
            $period->setTask($this->getReference('task'.$index));
            $period->setDuration($item[0]);
            $period->setInternalNumber($index);
            $period->setRealDuration($item[1]);
            $period->setDescription($item[2]);
            $manager->persist($period);
            $this->addReference('period'.$index, $period);
        }
        $manager->flush();
    }

    private $periods = [
        [25, 20, 'opop'],
        [11, 20, '123df'],
        [12, 20, 'asdf'],
        [13, 20, 'asdf'],
        [14, 20, '34eerw'],
        [15, 20, 'qtqregtwer'],
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