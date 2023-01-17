<?php

namespace App\Command;

use App\Entity\Region;
use App\Service\HttpClientService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:region',
    description: 'Add a short description for your command',
)]
class RegionCommand extends Command
{

    public function __construct(
        private HttpClientService $clientService,
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    /**
     * ExcecCommand configuration
     */
    protected function configure()
    {
        $this
            ->setDescription('Execute app:region to fetch all regions');
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('<info>Fetching all regions...');

        try {
            $response = $this->clientService->getFrom('https://geo.api.gouv.fr/regions/');
            $datas = $response->toArray();

            if (sizeof($datas) > 0) {

                $progressBar = new ProgressBar($output, count($datas));
                $progressBar->start();

                foreach ($datas as $data) {
                    $region = (new Region())
                        ->setName($data['nom'])
                        ->setCode($data['code'])
                    ;
                    $this->em->persist($region);
                    $progressBar->advance();
                }

                $this->em->flush();

                $progressBar->finish();

                return command::SUCCESS;
            }
        } catch (Exception $e) {
            return command::FAILURE;
        }
    }
}
