<?php

namespace TaskBundle\Services;

use BaseBundle\Entity\DateCondition;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\TaskEntry;
use UserBundle\Entity\User;

class TaskHandler extends EntityHandler
{
    /**
     * @var BaseHelper
     */
    private $helper;
    protected $notExistsMessage = ErrorMessages::REQUESTED_TASK_NOT_EXISTS;

    public function __construct(
        EntityManager $em,
        ApiResponseFormatter $apiResponseFormatter,
        RecursiveValidator $validator,
        BaseHelper $helper
    ) {
        parent::__construct($em, $apiResponseFormatter, $validator);
        $this->helper = $helper;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->em->getRepository('TaskBundle:TaskEntry');
    }

    /**
     * @param DateCondition $condition
     * @param Task $task
     * @param User $user
     * @return Result
     */
    public function generateRepetitiveTasks(DateCondition $condition, Task $task, User $user)
    {
        $this->em->persist($condition);
        $this->em->persist($task);
        $this->em->flush();

        $days = $this->helper->getDaysByDateCondition($condition);

        /** @var \DateTime $day */
        foreach ($days as $day) {
            $deadline = (clone $day)->modify('+' . $condition->getDaysBeforeDeadline() . 'days');
            $taskEntry = (new TaskEntry())
                ->setDate($day)
                ->setUser($user)
                ->setDeadLine($deadline)
                ->setDateCondition($condition)
                ->setTask($task);
            $this->em->persist($taskEntry);
        }

        if ($condition->isNewTasksCreate()) {
            $title = 'Создать новые задачи типа "'.$task->getTitle().'"';
            $this->createTaskOfCreationNewEntities($condition->getEndDate(), $user, $title);
        }

        $this->em->flush();

        return Result::createSuccessResult();
    }

    /**
     * @param \DateTime $date
     * @param User $user
     * @param $title
     * @param int $deadLineOffset
     * @return Task
     */
    public function createTaskOfCreationNewEntities(\DateTime $date, User $user, $title, $deadLineOffset = 10)
    {
        $taskOfCreationEntities = (new Task())
            ->setTitle($title);
        $this->em->persist($taskOfCreationEntities);

        $taskEntry = (new TaskEntry())
            ->setTask($taskOfCreationEntities)
            ->setUser($user)
            ->setDate($date)
            ->setDeadLine((clone $date)->modify('+' . $deadLineOffset . 'days'));
        $this->em->persist($taskEntry);

        $this->em->flush($taskOfCreationEntities);

        return $taskOfCreationEntities;
    }

    /**
     * @param $title
     * @return null|object
     */
    protected function getTaskByName($title)
    {
        //TODO: Тут должен быть Id существующей записи. Пока не использую
        return $this->getRepository()->findOneBy(['title' => $title]);
    }
}