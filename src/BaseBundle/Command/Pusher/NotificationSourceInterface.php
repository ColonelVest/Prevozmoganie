<?php

namespace BaseBundle\Command\Pusher;

interface NotificationSourceInterface
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array ;
}
