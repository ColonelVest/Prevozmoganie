<?php

namespace TaskBundle\Command;

use Doctrine\Common\Collections\Criteria;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TaskBundle\Entity\TaskEntry;
use UserBundle\Entity\User;

class TaskListPusherCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('task:push_tasks')
            ->setDescription('Pushes the tasks list to telegram');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $botToken = $this->getContainer()->getParameter('dzdorbot_token');
        $personalChatId = $this->getContainer()->getParameter('personal_chat_id');

        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $criteria->where($expr->andX($expr->eq('date', new \DateTime('midnight')), $expr->eq('isCompleted', false)));
        $userResult = $this->getContainer()->get('user_handler')->getUser('angry');

        /** @var User $user */
        $user = $userResult->getData();

        $criteria->andWhere(Criteria::expr()->eq('user', $user));
        $res = $this->getContainer()->get('task_entry_handler')->getEntities($criteria);

        $tasksList = '';
        /** @var TaskEntry $taskEntry */
        foreach ($res->getData() as $taskNumber => $taskEntry) {
            $tasksList .= ($taskNumber + 1) . '. ' . $taskEntry->getTask()->getTitle() . "\n";
        }
        $text = 'Tasks for today: ' . urlencode("\n" . $tasksList);

        $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$personalChatId&text=$text&parse_mode=HTML";

        $client = new Client();
        $response = $client->get($url, [
            RequestOptions::HTTP_ERRORS => true,
        ]);

        $output->writeln('Result code: ' . $response->getStatusCode());
    }
}
