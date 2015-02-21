<?php

namespace AppBundle\Command;

use AppBundle\Entity\Poll\Election;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListElectionGroupsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:elections:list-groups')
            ->setDescription('List the election groups')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $electionRuler = $this->getContainer()->get('app.election_ruler');
        $criterias = $electionRuler->getValidCriterias();

        $output->writeln('Groups : '.implode(', ', array_keys($criterias)));
    }
}
