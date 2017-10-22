<?php

namespace UserBundle\Services;

use BaseBundle\Services\BaseHelper;
use Doctrine\ORM\EntityManager;
use TaskBundle\Entity\Challenge;
use UserBundle\Entity\Achievement;
use UserBundle\Entity\User;

class AchievementManager
{
    /** @var  EntityManager $em */
    private $em;
    /** @var  BaseHelper $helper */
    private $helper;

    public function __construct(EntityManager $em, BaseHelper $helper)
    {
        $this->em = $em;
        $this->helper = $helper;
    }

    /**
     * @param User[] $users
     * @return int
     */
    public function generate(array $users = [])
    {
        if (count($users) == 0) {
            //TODO: Поменяю на поиск по критерию
            $users = $this->em->getRepository('UserBundle:User')->findAll();
        }

        $usersArrayWithIdKeys = $this->helper->getArrayWithKeysByMethodName($users);

        $taskAchievements = $this->em
            ->getRepository('UserBundle:Achievement')
            ->findBy(['classType' => 'task']);

        $numberOfAchievements = 0;
        foreach ($taskAchievements as $achievement) {
            $numberOfAchievements += $this->addAchievement($usersArrayWithIdKeys, $achievement);
        }

        $this->em->flush();

        return $numberOfAchievements;
    }

    /**
     * @param array $usersWithIdKeys
     * @param Achievement $achievement
     * @return int
     */
    private function addAchievement(array $usersWithIdKeys, Achievement $achievement)
    {
        $endDate = new \DateTime('midnight');
        $beginDate = (clone $endDate)->sub($achievement->getDateInterval());
        $statistic = $this->em
            ->getRepository('TaskBundle:Task')
            ->getTaskCompletionStatistic($beginDate, $endDate, array_keys($usersWithIdKeys));
        $numberOfAchievements = 0;

        foreach ($statistic as $userStatistic) {
            if ($userStatistic['TaskCount'] > 0 && $userStatistic['UnCompletedCount'] == 0) {
                $userId = $userStatistic['user_id'];
                /** @var User $user */
                $user = $usersWithIdKeys[$userId];
                $user->addAchievement($achievement);
                $numberOfAchievements++;
            }
        }

        return $numberOfAchievements;
    }
}