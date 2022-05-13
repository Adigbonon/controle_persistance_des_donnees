<?php

namespace App\Command;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'company:create',
    description: 'Création d une compagnie',
)]
class CompanyCreateCommand extends Command
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
            ->addOption('companyName', null, InputOption::VALUE_REQUIRED, 'Nom de la compagnie')
            ->addOption('companyNationality', null, InputOption::VALUE_REQUIRED, 'Pays de la compagnie')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $companyName = $input->getOption('companyName');
        $companyNationality = $input->getOption('companyNationality');

        $company = new Company();
        $company->setName($companyName);
        $company->setNationality($companyNationality);

        $this->entityManager->persist($company);
        $this->entityManager->flush();

        $io->writeln("Le nom de la compagnie est : ".$companyName);
        $io->writeln("Elle est dans le pays : ".$companyNationality);

        return Command::SUCCESS;
    }
}
