<?php

namespace PusherBundle\Services;

use PusherBundle\Dto\Notification;

class SettingsSource implements NotificationSourceInterface
{
    /** @var array */
    private $pusherSettings;

    public function __construct(array $pusherSettings)
    {
        $this->pusherSettings = $pusherSettings;
    }

    /**
     * @inheritDoc
     */
    public function getNotifications(): array
    {
        $notifications = [];
        foreach ($this->pusherSettings as $key => $settings) {
            $text = $settings['title'];
            if (array_key_exists('list', $settings)) {
                $text .= ': ' . urlencode(
                        "\n" . $this->getArrayAsString($settings['list'])
                    );
            }

            $notifications[] = (new Notification())
                ->setMessage($text)
                ->setPushTimes($settings['times']);
        }

        return $notifications;
    }

    /**
     * @param string[] $array
     *
     * @return string
     */
    private function getArrayAsString(array $array)
    {
        $result = '';
        foreach ($array as $index => $entry) {
            $result .= ($index + 1) . '. ' . $entry . "\n";
        }

        return $result;
    }
}
