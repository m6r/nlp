<?php

namespace AppBundle\Command;

use AppBundle\Entity\Poll\Election;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateElectionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:elections:generate')
            ->setDescription('Generate the elections entities from elections rules')
            ->addArgument('group', InputArgument::REQUIRED, 'The rule group to generate')
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'The names of the elections to generate, with %group% and %criteria% placeholders.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = $input->getArgument('group');
        $namePattern = $input->getOption('name') ?: '%group% - %criteria%';

        $electionRuler = $this->getContainer()->get('app.election_ruler');
        $criterias = $electionRuler->getValidCriterias();

        if (!array_key_exists($group, $criterias)) {
            throw new \Error('This election group does not exist.');
        }

        // Ask dates

        $validateDate = function ($answer) {
            $date = \DateTime::createFromFormat('d-m-Y H:i:s', $answer);
            if (!$date) {
                throw new \RunTimeException('Bad date format.');
            }

            return $date;
        };

        $dialog = $this->getHelperSet()->get('dialog');

        $openCandidacyDate = $dialog->askAndValidate(
            $output,
            'Date of opening of candidacies (dd-mm-yyyy hh:mm:ss) : ',
            $validateDate,
            false
        );

        $closeCandidacyDate = $dialog->askAndValidate(
            $output,
            'Date of closing of candidacies (dd-mm-yyyy hh:mm:ss) : ',
            $validateDate,
            false
        );

        $openDate = $dialog->askAndValidate(
            $output,
            'Date of opening of votes (dd-mm-yyyy hh:mm:ss) : ',
            $validateDate,
            false
        );

        $closeDate = $dialog->askAndValidate(
            $output,
            'Date of closing of votes (dd-mm-yyyy hh:mm:ss) : ',
            $validateDate,
            false
        );

        // Get all the criterias in the group
        $criterias = $criterias[$group];

        foreach ($criterias as $criteria) {
            $name = str_replace(
                array('%group%', '%criteria%'),
                array($group, $criteria),
                $namePattern
            );

            $election = new Election();
            $election->setName($name);
            $election->setDescription($name);
            $election->setGroup($group);
            $election->setCriteria($criteria);
            $election->setOpenCandidacyDate($openCandidacyDate);
            $election->setCloseCandidacyDate($closeCandidacyDate);
            $election->setOpenDate($openDate);
            $election->setCloseDate($closeDate);

            $errors = $this->getContainer()->get('validator')->validate($election);

            if (count($errors) > 0) {
                $output->writeln((string) $errors);

                return;
            }

            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $em->persist($election);
        }

        $em->flush();

        $output->writeln('Elections created.');
    }
}
