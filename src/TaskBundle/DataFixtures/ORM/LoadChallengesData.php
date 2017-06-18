<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 18:22
 */

namespace TaskBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TaskBundle\Entity\Challenge;
use TaskBundle\Entity\Task;
use UserBundle\Entity\User;

class LoadChallengesData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const CHALLENGES_DATA = [
        ['beginOffset' => '+5 days', 'endOffset' => '+15 days', 'award' => 'nothing'],
        ['beginOffset' => '+1 days', 'endOffset' => '+11 days', 'award' => 'nothing again'],
        ['beginOffset' => '+10 days', 'endOffset' => '+11 days', 'award' => 'nothing again'],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::CHALLENGES_DATA as $index => $challengeData) {
            /** @var Task $task */
            $task = $this->getReference('task' . $index);
            /** @var User $user */
            $user = $this->getReference('fixt_user');

            $challenge = (new Challenge())
                ->setBegin(new \DateTime($challengeData['beginOffset']))
                ->setEnd(new \DateTime($challengeData['endOffset']))
                ->setAward($challengeData['award'])
                ->setUser($user)
                ->addTask($task);
            $manager->persist($challenge);
            $this->setReference('challenge' . $index, $challenge);
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
        return 4;
    }
}