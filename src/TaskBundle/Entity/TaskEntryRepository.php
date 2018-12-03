<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * TaskEntryRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class TaskEntryRepository extends EntityRepository
{
    /**
     * @param array $tasksIds
     * @param \DateTime $date
     * @return array
     */
    public function getTaskLinesLengths(array $tasksIds, \DateTime $date = null)
    {
        $date = $date ?? new \DateTime('midnight');
        $tasksIdsString = join(',', $tasksIds);
        $request = $this->getEntityManager()->getConnection()->prepare(
            "SELECT
  x.task_id,
  count(*) AS lineLength
FROM task_entries x
  LEFT JOIN (SELECT
          task_id,
          MAX(date) AS max_date
        FROM task_entries
        WHERE is_completed = 0 AND date < :date
        GROUP BY task_id) y ON x.task_id = y.task_id
WHERE (y.max_date IS NULL OR date > y.max_date) AND date < :date AND  x.task_id IN ($tasksIdsString)
GROUP BY x.task_id"
        );
        $request->execute(
            [
                ':date' => $date->format('Y-m-d')
            ]
        );
        return $request->fetchAll();
    }

    public function getLastDayWithUncompletedTask(\DateTime $date, User $user)
    {
        $request = $this->getEntityManager()->getConnection()->prepare(
            "SELECT MAX(date) as uncompleted_day
FROM task_entries
WHERE date < :date AND is_completed = 0 AND user_id = :user_id"
        );
        $request->execute(
            [
                ':date' => $date->format('Y-m-d'),
                ':user_id' => $user->getId()
            ]
        );

        return $request->fetch()['uncompleted_day'];
    }
}
