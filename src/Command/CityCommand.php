<?php

namespace App\Command;

use App\Entity\City;
use App\Entity\Department;
use App\Entity\PostalCode;
use App\Repository\DepartmentRepository;
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
    name: 'app:city',
    description: 'Add a short description for your command',
)]
class CityCommand extends Command
{

    public function __construct(
        private HttpClientService $clientService,
        private RegionRepository $regionRepository,
        private DepartmentRepository $departmentRepository,
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
            ->setDescription('Execute app:region to fetch all cities');
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('<info>Fetching all cities...');

        try {
            $response = $this->clientService->getFrom('https://geo.api.gouv.fr/communes/');
            $datas = $response->toArray();

            if (sizeof($datas) > 0) {

                $progressBar = new ProgressBar($output, count($datas));
                $progressBar->start();

                foreach ($datas as $data) {
                    $department = $this->departmentRepository->findOneBy(['code' => $data['codeDepartement']]);

                    if ($department !== null) {
                        $city = (new City())
                            ->setName($data['nom'])
                            ->setCode($data['code'])
                            ->setDepartment($department)
                            ->setPopulation($data['population'])
                            ->setSiren($data['siren'])
                        ;

                        foreach ($data['codesPostaux'] as $postalCode) {
                            $newPostCode = (new PostalCode())
                                ->setCode($postalCode)
                            ;
                            $city->addPostalCode($newPostCode);
                            $this->em->persist($newPostCode);
                        }
                        $this->em->persist($city);
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
