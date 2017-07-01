<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 25/06/2017
 * Time: 23:30
 */

namespace BaseBundle\Command;


use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCommand;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateApiFunctionalityCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('pv:generate:api_functionality')
            ->setDefinition([
                new InputOption('entity', '', InputOption::VALUE_REQUIRED, 'Entity name in format with back slashes')
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($input->getOption('entity'));
        $entity = Validators::validateEntityName($input->getOption('entity'));
        $this->getContainer()->get('pv.pv_generator')->generate($entity);
    }
}