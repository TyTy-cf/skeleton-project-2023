<?php

namespace App\Command;

use App\Entity\Department;
use App\Repository\RegionRepository;
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
    name: 'app:department',
    description: 'Add a short description for your command',
)]
class DepartmentCommand extends Command
{

    public function __construct(
        private HttpClientService $clientService,
        private RegionRepository $regionRepository,
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
            ->setDescription('Execute app:region to fetch all departments');
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('<info>Fetching all departments...');

        try {
            $response = $this->clientService->getFrom('https://geo.api.gouv.fr/departements/');
            $datas = $response->toArray();

            if (sizeof($datas) > 0) {

                $progressBar = new ProgressBar($output, count($datas));
                $progressBar->start();

                foreach ($datas as $data) {
                    $region = $this->regionRepository->findOneBy(['code' => $data['code']]);

                    if ($region !== null) {
                        $department = (new Department())
                            ->setName($data['nom'])
                            ->setCode($data['code'])
                            ->setRegion($region)
                        ;
                        $this->em->persist($department);
                    }
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
