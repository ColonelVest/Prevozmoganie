<?php

namespace PusherBundle\Dto;

class Notification
{
    /** @var string */
    private $message;
    /** @var string[]  */
    private $pushTimes = [];

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage(string $message): Notification
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getPushTimes(): array
    {
        return $this->pushTimes;
    }

    /**
     * @param string[] $pushTimes
     *
     * @return Notification
     */
    public function setPushTimes(array $pushTimes): Notification
    {
        $this->pushTimes = $pushTimes;

        return $this;
    }
}
