<?php

namespace TaskBundle\Services;

use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\ApiResponseFormatter;
use BaseBundle\Services\BaseHelper;
use BaseBundle\Services\EntityHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use TaskBundle\Entity\RepetitiveTask;
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
     * @param RepetitiveTask $repetitiveTask
     * @return Result
     */
    public function generateRepetitiveTasks(RepetitiveTask $repetitiveTask)
    {
        $days = $this->helper->getDaysFromRepetitiveEntity($repetitiveTask);

        $task = (new Task())
            ->setBeginTime($repetitiveTask->getBeginTime())
            ->setEndTime($repetitiveTask->getEndTime())
            ->setDescription($repetitiveTask->getDescription())
            ->setTitle($repetitiveTask->getTitle());
        $this->em->persist($task);
        foreach ($days as $day) {
            $taskEntry = (new TaskEntry())
                ->setDate($day)
                ->setUser($repetitiveTask->getUser())
                ->setDeadLine((clone $day)->modify('+' . $repetitiveTask->getDaysBeforeDeadline() . 'days'))
                ->setTask($task);
            $this->em->persist($taskEntry);
        }

        if ($repetitiveTask->isNewTasksCreate()) {
            $title = 'Создать новые задачи типа "'.$repetitiveTask->getTitle().'"';
            $this->createTaskOfCreationNewEntities($repetitiveTask->getEndDate(), $repetitiveTask->getUser(), $title);
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