<?php

namespace BaseBundle\Command;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskBundle\Entity\TaskEntry;

class PusherCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('cron_push')
            ->setDescription('Pushes messages using settings');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();

        $pusherSettings = $this->getContainer()->getParameter('pusher_settings');
        foreach ($pusherSettings as $key => $settings) {
            if ($now->format('H:i') !== $settings['time']) {
                continue;
            }

            $botToken = $this->getContainer()->getParameter('dzdorbot_token');
            $personalChatId = $this->getContainer()->getParameter('personal_chat_id');

            $text = $settings['title'].': '.urlencode(
                    "\n".$this->getArrayAsString($settings['list'])
                );

            $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$personalChatId&text=$text&parse_mode=HTML";

            $client = new Client();
            $response = $client->get(
                $url,
                [
                    RequestOptions::HTTP_ERRORS => true,
                ]
            );

            $output->writeln('Result code: '.$response->getStatusCode());
        }
    }

    private function getArrayAsString($array)
    {
        $result = '';
        /** @var TaskEntry $entry */
        foreach ($array as $index => $entry) {
            $result .= ($index + 1).'. '.$entry."\n";
        }

        return $result;
    }
}
