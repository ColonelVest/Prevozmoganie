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
        $beginDate = (new \DateTime())->sub($achievement->getDateInterval());
        $statistic = $this->getTaskCompletionStatistic($beginDate, new \DateTime(), array_keys($usersWithIdKeys));
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

    private function getTaskCompletionStatistic(\DateTime $beginDate, \DateTime $endDate, $userIds)
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
  task_entries.user_id AS user_id,
  fos_user.username
FROM task_entries
  JOIN fos_user ON fos_user.id = task_entries.user_id
  JOIN tasks ON task_entries.task_id = tasks.id
WHERE task_entries.date BETWEEN :beginDate AND :currentDate AND task_entries.user_id IN (:userIds) AND tasks.deleted_at IS NULL
GROUP BY task_entries.user_id'
        );
        $request->execute(
            [
                ':currentDate' => $endDate->format('Y-m-d'),
                ':beginDate' => $beginDate->format('Y-m-d'),
                ':userIds' => join(', ', $userIds),
            ]
        );

        return $request->fetchAll();
    }
}