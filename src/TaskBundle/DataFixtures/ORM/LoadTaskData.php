<?php

namespace TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TaskBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->tasks as $index => $item) {
            $task = new Task();
            $task->setTitle($item[0]);
            $task->setBody($item[1]);
            $task->setUpdatedBy($this->getReference('fixt_user2'));
            $manager->persist($task);
            $this->addReference('task'.$index, $task);
        }
        $manager->flush();
    }

    private $tasks = [
        ["Убрать мусор", "Убрать аккуратно мусор"],
        ["Помыть пол", "Помыть дома полы"],
        ["Купить картошку", "Купить картошку 5кг"],
        ["Поесть", "Поесть человеческую пищу"],
        ["Покодить", 'Писать код'],
        ['Погамать', 'Погамать в готику']
    ];

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}