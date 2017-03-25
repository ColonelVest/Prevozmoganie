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

    /**
     * @param RepetitiveTask $task
     * @return Result
     */
    public function generateRepetitiveTasks(RepetitiveTask $task)
    {
        $capitalizedDaysOfWeek = [];
        foreach ($task->getDaysOfWeek() as $dayOfWeek) {
            $capitalizedDaysOfWeek[] = ucfirst($dayOfWeek);
        }

        $end = (clone $task->getEndDate())->add(new \DateInterval('P1D'));
        $templateTask = (new Task())
            ->setBeginTime($task->getBeginTime())
            ->setEndTime($task->getEndTime())
            ->setDescription($task->getDescription())
            ->setTitle($task->getTitle());

        $period = new \DatePeriod($task->getBeginDate(), new \DateInterval('P1D'), $end);
        foreach ($period as $dayNumber => $day) {
            $weekNumber = floor($dayNumber / 7);
            /** @var \DateTime $day */
            if (($weekNumber % $task->getWeekFrequency()) == 0) {
                $dayOfWeek = $day->format('D');
                if (in_array($dayOfWeek, $capitalizedDaysOfWeek)) {
                    $deadlineDate = (clone $day)->modify('+' . $task->getDaysBeforeDeadline() . 'days');

                    $newTask = (clone $templateTask)
                        ->setDeadline($deadlineDate)
                        ->setDate($day);
                    $this->em->persist($newTask);

                }
            }
        }

        if ($task->isNewTasksCreate()) {
            $newTasksCreateTask = (new Task())
                ->setDate($task->getEndDate())
                ->setTitle('Создать новые задачи типа "' .$task->getTitle() . '"');

            $this->em->persist($newTasksCreateTask);
        }

        $this->em->flush();

        return Result::createSuccessResult();
    }
}