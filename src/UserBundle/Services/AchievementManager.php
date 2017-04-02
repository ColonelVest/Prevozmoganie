<?php

namespace UserBundle\Services;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class AchievementManager
{
    /** @var  EntityManager $em */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param User[] $users
     * @return array
     */
    public function generate(array $users = [])
    {
        if (count($users) == 0) {
            //TODO: Поменяю на поиск по критерию
            $users = $this->em->getRepository('UserBundle:User')->findAll();
        }

        $achievements = [];
        foreach (self::ACHIEVEMENT_TYPES as $achievement => $dateString) {
            $achievements[$achievement] = $this->getUserIdsWithAllCompletedTasks($users, new \DateTime($dateString));
        }

        return $achievements;
    }

    /**
     * @param User[] $users
     * @param \DateTime|null $beginDate
     * @return array
     */
    private function getUserIdsWithAllCompletedTasks(array $users = [], \DateTime $beginDate = null)
    {
        $beginDate = is_null($beginDate) ? new \DateTime('-1 month') : $beginDate;
        $statistic = $this->getTaskCompletionStatistic($beginDate);
        $userIdsWithAllCompletedTasks = [];

        foreach ($statistic as $userStatistic) {
            if ($userStatistic['CompletedCount'] > 0 && $userStatistic['UnCompletedCount'] == 0) {
                $userIdsWithAllCompletedTasks[] = $userStatistic['user_id'];
            }
        }

        return $userIdsWithAllCompletedTasks;
    }

    private function getTaskCompletionStatistic(\DateTime $beginDate)
    {
        $request = $this->em->getConnection()->prepare(
            'SELECT
  count(*) as TaskCount,
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
WHERE user_id IS NOT NULL AND tasks.date < :currentDate AND tasks.date >= :beginDate AND user_id IN (1, 2)
GROUP BY user_id'
        );
        $request->execute(
            [
                ':currentDate' => (new \DateTime())->format('Y-m-d'),
                ':beginDate' => $beginDate->format('Y-m-d'),
            ]
        );

        return $request->fetchAll();
    }
}