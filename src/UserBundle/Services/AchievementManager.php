<?php

namespace UserBundle\Services;

use BaseBundle\Services\BaseHelper;
use Doctrine\ORM\EntityManager;
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

        foreach ($taskAchievements as $achievement) {
            $this->addAchievement($usersArrayWithIdKeys, $achievement);
        }
    }

    /**
     * @param array $usersWithIdKeys
     * @param Achievement $achievement
     */
    private function addAchievement(array $usersWithIdKeys, Achievement $achievement)
    {
        $beginDate = (new \DateTime())->sub($achievement->getDateInterval());
        $statistic = $this->getTaskCompletionStatistic($beginDate, array_keys($usersWithIdKeys));

        foreach ($statistic as $userStatistic) {
            if ($userStatistic['CompletedCount'] > 0 && $userStatistic['UnCompletedCount'] == 0) {
                $userId = $userStatistic['user_id'];
                /** @var User $user */
                $user = $usersWithIdKeys[$userId];
                $user->addAchievement($achievement);
            }
        }
    }

    private function getTaskCompletionStatistic(\DateTime $beginDate, $userIds)
    {
        $request = $this->em->getConnection()->prepare(
            'SELECT
  count(*) AS TaskCount,
  SUM(CASE WHEN is_completed = 1
    THEN 1
      ELSE 0 END) AS CompletedCount,
  SUM(CASE WHEN is_completed = 0
    THEN 1
      ELSE 0 END) AS UnCompletedCount,
  user_id,
  fos_user.username
FROM tasks
  JOIN fos_user ON fos_user.id = tasks.user_id
WHERE user_id IS NOT NULL AND tasks.date < :currentDate AND tasks.date >= :beginDate AND user_id IN (:userIds)
GROUP BY user_id'
        );
        $request->execute(
            [
                ':currentDate' => (new \DateTime())->format('Y-m-d'),
                ':beginDate' => $beginDate->format('Y-m-d'),
                ':userIds' => join(', ', $userIds)
            ]
        );

        return $request->fetchAll();
    }
}