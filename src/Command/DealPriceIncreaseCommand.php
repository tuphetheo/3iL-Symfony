<?php

namespace App\Command;

use App\Repository\DealRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'deal:price:increase',
    description: 'Augmente le prix des deals',
)]
class DealPriceIncreaseCommand extends Command
{
    private DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('price', InputArgument::REQUIRED, 'Valeur à ajouter au prix')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'Id du deal à modifier')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Modifier tous les deals');
    }

    /**
     * @throws Exception
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('id') && $input->getOption('all')) {
            throw new Exception('Vous ne pouvez pas utiliser --id et --all simultanément');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if ($input->getOption('id')) {
            $deal = $this->dealRepository->find($input->getOption('id'));

            if (!$deal) {
                $io->error('Deal non trouvé');
                return Command::FAILURE;
            }

            $oldPrice = $deal->getPrice();
            $deal->setPrice($deal->getPrice() + $input->getArgument('price'));

            $this->dealRepository->add($deal, true);
            $io->success("Le prix du deal {$deal->getId()} a été modifié de {$oldPrice} à {$deal->getPrice()}");
        } else {
            $deals = $this->dealRepository->findAll();
            $table = new Table($output);
            $table->setHeaders(array('ID', 'Old Price', 'New Price'));

            foreach ($deals as $deal) {
                $oldPrice = $deal->getPrice();
                $deal->setPrice($deal->getPrice() + $input->getArgument('price'));
                $table->addRow(array($deal->getId(), $oldPrice, $deal->getPrice()));
                $this->dealRepository->add($deal, true);
            }

            $table->render();
            $io->success('Les deals ont été modifiés');
        }

        return Command::SUCCESS;
    }
}
