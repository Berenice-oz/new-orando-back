<?php

namespace App\CronJob;

use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetStatusCommand extends Command
{
    protected static $defaultName = 'app:set:status';
    private $walkRepository;
    private $em;

    public function __construct(WalkRepository $walkRepository, EntityManagerInterface $em)
    {
        $this->walkRepository = $walkRepository;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription("Update walk's status if walk's debut date is earlier than current date ")
            ->setHelp("");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Récupérer la date du jour
        // Chercher les rando quiont une date strictement inférieur à la date du jour et que le statut de la rando est a venir
        // Pour chaque rando on update le statut de la rando a terminé
        $walks = $this->walkRepository->findForCronJob();
        $nbWalks = count($walks);
        foreach($walks as $walk){
            $walk->setStatus(2);
            $this->em->flush($walk);
        }
        $output->writeln([
            'Update to archived walks',
            '===========================',
            $nbWalks .' walk(s) updated',
        ]);
        return Command::SUCCESS;

        return Command::FAILURE;
    }
}
