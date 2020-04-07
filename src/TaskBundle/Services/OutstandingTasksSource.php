<?php

namespace TaskBundle\Services;

use Doctrine\Common\Collections\Criteria;
use PusherBundle\Dto\Notification;
use PusherBundle\Services\NotificationSourceInterface;
use TaskBundle\Entity\TaskEntry;
use UserBundle\Entity\User;
use UserBundle\Services\UserHandler;

class OutstandingTasksSource implements NotificationSourceInterface
{
    const PUSH_TIMES = [
        '06:00',
        '11:00',
        '18:00',
        '20:00',
    ];

    /** @var TaskEntryHandler */
    private $taskEntryHandler;

    /** @var UserHandler */
    private $userHandler;

    public function __construct(TaskEntryHandler $taskEntryHandler, UserHandler $userHandler)
    {
        $this->taskEntryHandler = $taskEntryHandler;
        $this->userHandler = $userHandler;
    }

    /**
     * @inheritDoc
     */
    public function getNotifications(): array
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $criteria->where($expr->andX($expr->eq('date', new \DateTime('midnight')), $expr->eq('isCompleted', false)));
        $userResult = $this->userHandler->getUser('angry');

        /** @var User $user */
        $user = $userResult->getData();

        $criteria->andWhere(Criteria::expr()->eq('user', $user));
        $res = $this->taskEntryHandler->getEntities($criteria);
        if (empty($res->getData())) {
            return null;
        }

        $tasksList = '';
        /** @var TaskEntry $taskEntry */
        foreach ($res->getData() as $taskNumber => $taskEntry) {
            $tasksList .= ($taskNumber + 1).'. '.$taskEntry->getTask()->getTitle()."\n";
        }

        return [
            (new Notification())
                ->setMessage('Outstanding tasks for today: '.urlencode("\n".$tasksList))
                ->setPushTimes(self::PUSH_TIMES),
        ];
    }
}
