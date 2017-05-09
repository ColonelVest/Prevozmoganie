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
            if (isset($item[2])) {
                foreach ($item[2] as $dateString) {
                    $task = new Task();
                    $task->setTitle($item[0]);
                    $task->setDescription($item[1]);
                    $date = \DateTime::createFromFormat('dmY', $dateString);
                    $task->setDate($date);
                    $task->setDeadline((clone $date)->add(new \DateInterval('P1D')));
                    $manager->persist($task);
                    $this->addReference('task'.$index.$dateString, $task);
                    $task->setUser($this->getReference('fixt_user'));
                }
            } else {
                $task = new Task();
                $task->setTitle($item[0]);
                $task->setDescription($item[1]);
                $manager->persist($task);
                $this->addReference('task'.$index, $task);
                $task->setUser($this->getReference('fixt_user'));
            }
        }
        $manager->flush();
    }

    private $tasks = [
        ["Убрать мусор", "Убрать аккуратно мусор"],
        ["Помыть пол", "Помыть дома полы"],
        ["Купить картошку", "Купить картошку 5кг"],
        ["Поесть", "Поесть человеческую пищу"],
        ["Покодить", 'Писать код'],
        ['Погамать', 'Погамать в готику'],
        ['Постирать пол', 'Постирать пол', ['05052017', '06052017', '07052017']],
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