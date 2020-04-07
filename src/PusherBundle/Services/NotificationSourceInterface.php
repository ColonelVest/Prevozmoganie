<?php

namespace PusherBundle\Services;

use PusherBundle\Dto\Notification;

interface NotificationSourceInterface
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array ;
}
