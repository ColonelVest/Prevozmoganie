<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Команда генерации ачивок
 * Class AchievementCommand
 * @package UserBundle\Command
 */
class AchievementCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:achivment_command')
            ->setDescription('Create achievements for users');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfAchievements = $this->getContainer()->get('achievement_manager')->generate();
        $output->writeln($numberOfAchievements . ' achievements was generated');
    }
}
