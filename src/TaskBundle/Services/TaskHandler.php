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
        return $this->em->getRepository('TaskBundle:Task');
    }

    /**
     * @param RepetitiveTask $repetitiveTask
     * @return Result
     */
    public function generateRepetitiveTasks(RepetitiveTask $repetitiveTask)
    {
        $days = $this->helper->getDaysFromRepetitiveEntity($repetitiveTask);

        $templateTask = (new Task())
            ->setBeginTime($repetitiveTask->getBeginTime())
            ->setEndTime($repetitiveTask->getEndTime())
            ->setDescription($repetitiveTask->getDescription())
            ->setUser($repetitiveTask->getUser())
            ->setTitle($repetitiveTask->getTitle());

        foreach ($days as $day) {
            $deadlineDate = (clone $day)->modify('+'.$repetitiveTask->getDaysBeforeDeadline().'days');
            $task = (clone $templateTask)
                ->setDate($day)
                ->setDeadline($deadlineDate);
            $this->em->persist($task);
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
        $newTasksCreateTask = (new Task())
            ->setDate($date)
            ->setTitle($title)
            ->setUser($user)
            ->setDeadline((clone $date)->modify('+'.$deadLineOffset.'days'));

        $this->em->persist($newTasksCreateTask);
        $this->em->flush($newTasksCreateTask);

        return $newTasksCreateTask;
    }
}