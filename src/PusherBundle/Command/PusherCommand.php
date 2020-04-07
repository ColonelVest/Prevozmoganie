<?php

namespace PusherBundle\Command;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use PusherBundle\Services\NotificationSourceInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PusherCommand extends ContainerAwareCommand
{
    /** @var NotificationSourceInterface[] */
    private $sources;

    private function addSource(NotificationSourceInterface $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pusher:cron_push')
            ->setDescription('Pushes messages using settings');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new DateTime();
        $this
            ->addSource($this->getContainer()->get('outstanding_tasks_source'))
            ->addSource($this->getContainer()->get('settings_source'));

        foreach ($this->sources as $source) {
            foreach ($source->getNotifications() as $notification) {
                foreach ($notification->getPushTimes() as $pushTime) {
                    if ($now->format('H:i') !== $pushTime) {
                        continue;
                    }

                    $this->sendMessage($notification->getMessage());
                }
            }
        }
    }

    /**
     * @param string $text
     *
     * @return ResponseInterface
     */
    protected function sendMessage(string $text): ResponseInterface
    {
        $botToken = $this->getContainer()->getParameter('dzdorbot_token');
        $personalChatId = $this->getContainer()->getParameter('personal_chat_id');

        $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$personalChatId&text=$text&parse_mode=HTML";

        $client = new Client();

        return $client->get(
            $url,
            [
                RequestOptions::HTTP_ERRORS => true,
            ]
        );
    }
}
