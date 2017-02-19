<?php

namespace TaskBundle\Services;


use BaseBundle\Models\ErrorMessages;
use BaseBundle\Models\Result;
use BaseBundle\Services\EntityHandler;
use TaskBundle\Entity\Task;

class TaskHandler extends EntityHandler
{
    public function getTaskById($taskId)
    {
        $task = $this->em->find('TaskBundle:Task', $taskId);
        if (is_null($task)) {
            return Result::createErrorResult([ErrorMessages::REQUESTED_TASK_NOT_EXISTS]);
        }

        return Result::createSuccessResult($task);
    }

    public function getTasks() : Result
    {
        $tasks = $this->em->getRepository('TaskBundle:Task')->findAll();

        return Result::createSuccessResult($tasks);
    }

    public function createTask(Task $task) : Result
    {
        return $this->validateEntityAndGetResult($task);
    }

    public function deleteTask(Task $task)
    {
        $this->em->remove($task);
        $this->em->flush();

        return Result::createSuccessResult($task->getId());
    }

    public function deleteTaskById($taskId) : Result
    {
        $result = $this->getTaskById($taskId);
        if ($result->getIsSuccess()) {
            return $this->deleteTask($result->getData());
        }

        return $result;
    }
}