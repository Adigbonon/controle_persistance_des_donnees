<?php

namespace App\Command;

use App\Repository\TourRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tour:list',
    description: 'Liste tours d une compagnie',
)]
class TourListCommand extends Command
{
    private $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        parent::__construct();
        $this->tourRepository = $tourRepository;
    }

    protected function configure(): void
    {
        $this
            ->addOption('companyId', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);



        return Command::SUCCESS;
    }
}
