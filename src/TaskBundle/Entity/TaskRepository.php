<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class TaskRepository extends EntityRepository
{
    public function getTaskCompletionStatistic(\DateTime $beginDate, \DateTime $endDate, $userIds)
    {
        $userIdsString = join(', ', $userIds);
        $request = $this->getEntityManager()->getConnection()->prepare(
            "SELECT
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
WHERE task_entries.date >= :beginDate AND task_entries.date < :currentDate AND task_entries.user_id IN ($userIdsString) AND tasks.deleted_at IS NULL
GROUP BY task_entries.user_id"
        );
        $request->execute(
            [
                ':currentDate' => $endDate->format('Y-m-d'),
                ':beginDate' => $beginDate->format('Y-m-d'),
            ]
        );

        return $request->fetchAll();
    }
}
