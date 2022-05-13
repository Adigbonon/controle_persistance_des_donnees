<?php

namespace App\Command;

use App\Repository\TourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tour:editName',
    description: 'Modification du nom d un tour ',
)]
class TourEditNameCommand extends Command
{
    private $tourRepository;
    private $entityManager;

    public function __construct(tourRepository $tourRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->tourRepository = $tourRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('tourId', null, InputOption::VALUE_REQUIRED, 'Id du tour')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $tourId = $input->getOption('tourId');
        $tourRepository = $this->tourRepository;
        $tour = $tourRepository->find($tourId);

        if($tour){
            $newName = $io->ask("Nouveau nom : ", $tour->getMainEvent());
            $tour->setMainEvent($newName);

            $this->entityManager->flush();

        } else {
            $io->error("Tour inexistant");
        }

        return Command::SUCCESS;
    }
}
