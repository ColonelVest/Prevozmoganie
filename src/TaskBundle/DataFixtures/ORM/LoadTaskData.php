<?php

namespace TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\TaskEntry;
use UserBundle\Entity\User;

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
        /** @var User $user */
        $user = $this->getReference('fixt_user');
        foreach ($this->tasks as $index => $item) {
            $task = (new Task())
                ->setTitle($item[0])
                ->setDescription($item[1]);
            $manager->persist($task);
            $this->addReference('task'.$index, $task);

            if (isset($item[2])) {
                foreach ($item[2] as $dateString) {
                    $date = \DateTime::createFromFormat('dmY', $dateString);
                    $taskEntry = (new TaskEntry())
                        ->setDate($date)
                        ->setTask($task)
                        ->setDeadLine((clone $date)->add(new \DateInterval('P2D')))
                        ->setUser($user);
                    $manager->persist($taskEntry);
                    $this->addReference('task_entry'.$index.$dateString, $task);
                }
            } else {
                $taskEntry = (new TaskEntry())
                    ->setTask($task)
                    ->setUser($user);
                $manager->persist($taskEntry);
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