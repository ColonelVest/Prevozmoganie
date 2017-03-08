<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityRepository;
use TaskBundle\Entity\RepetitiveTask;
use TaskBundle\Entity\Task;

class TaskHandler extends EntityHandler
{
    protected $notExistsMessage = ErrorMessages::REQUESTED_TASK_NOT_EXISTS;

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:Task');
    }

    public function generateRepetitiveTasks(RepetitiveTask $task)
    {
        $capitalizedDaysOfWeek = [];
        foreach ($task->getDaysOfWeek() as $dayOfWeek) {
            $capitalizedDaysOfWeek[] = ucfirst($dayOfWeek);
        }

        foreach (new \DatePeriod($task->getBeginDate(), new \DateInterval('P1D'), $task->getEndDate()) as $day) {
            /** @var \DateTime $day */
            $dayOfWeek = $day->format('D');
            if (in_array($dayOfWeek, $capitalizedDaysOfWeek)) {
                $task = (new Task())
                    ->setDescription($task->getDescription())
                    ->setTitle($task->getTitle())
                    ->setDate($day);
                $this->em->persist($task);
                $this->em->flush();
            }
        }

        return Result::createSuccessResult();
    }
}