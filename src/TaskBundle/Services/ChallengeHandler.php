<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 18/06/2017
 * Time: 16:01
 */

namespace TaskBundle\Services;

use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;
use TaskBundle\Entity\Challenge;
use TaskBundle\Entity\Task;

class ChallengeHandler extends EntityHandler
{
    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Challenge');
    }

    public function checkCompleteness()
    {
        $qb = $this->getRepository()->createQueryBuilder('c');
        $qb
//            ->where('c.end = :currentDate')
            ->andWhere('c.isCompleted = 0');
//            ->andWhere($qb->expr()->in('c.user', array_keys($usersWithIdKeys)))
//            ->setParameters(['currentDate' => (new \DateTime('midnight'))]);
        $challenges = $qb->getQuery()->execute();

        /** @var Challenge $challenge */
        foreach ($challenges as $challenge) {
            $isCompleted = $this->isChallengeCompleted($challenge);
            $challenge->setIsCompleted($isCompleted);
        }

        $this->em->flush();
    }

    private function isChallengeCompleted(Challenge $challenge)
    {
        $taskIds = array_map(
            function ($task) {
                /** @var Task $task */
                return $task->getId();
            },
            $challenge->getTasks()->toArray()
        );

        $request = $this->em->getConnection()->prepare(
            '
            SELECT id
            FROM task_entries AS te
            WHERE
              te.is_completed = 0 
              AND te.task_id IN (:taskIds) 
              AND te.user_id = :userId 
              AND (te.date BETWEEN :beginDate AND :endDate)
            LIMIT 1'
        );

        $request->execute(
            [
                ':taskIds' => join(',', $taskIds),
                ':userId' => $challenge->getId(),
                ':beginDate' => $challenge->getBegin()->format('Y-m-d'),
                ':endDate' => $challenge->getEnd()->format('Y-m-d'),
            ]
        );

        return $request->rowCount() > 0;
    }
}