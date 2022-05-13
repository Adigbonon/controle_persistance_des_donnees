<?php

namespace App\Command;

use App\Entity\Tour;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tour:create',
    description: 'Création d un tour ',
)]
class TourCreateCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('tourMainEvent', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('tourCapacity', null, InputOption::VALUE_REQUIRED, 'Nombre de personnes')
            ->addOption('tourPrice', null, InputOption::VALUE_REQUIRED, 'Entrée par personne')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $tourMainEvent = $input->getOption('tourMainEvent');
        $tourCapacity = $input->getOption('tourCapacity');
        $tourPrice = $input->getOption('tourPrice');
        $tourStartDate = new DateTime('2022-05-13');
        $tourStopDate = new DateTime('2022-05-18');

        $tour = new Tour();
        $tour->setMainEvent($tourMainEvent);
        $tour->setCapacity($tourCapacity);
        $tour->setPrice($tourPrice);
        $tour->setStartDate($tourStartDate);
        $tour->setStopDate($tourStopDate);

        $this->entityManager->persist($tour);
        $this->entityManager->flush();

        $io->writeln("Tour : ".$tourMainEvent);
        $io->writeln("Nombre de participants : ".$tourCapacity);
        $io->writeln("Entrée par personne : ".$tourPrice);
        $io->writeln("Date de début : ".$tourStartDate->format('d-m-Y'));
        $io->writeln("Date de fin : ".$tourStopDate->format('d-m-Y'));

        return Command::SUCCESS;
    }
}
