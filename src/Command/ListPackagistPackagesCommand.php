<?php

namespace App\Command;

use App\PackagistClient\PackagistClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ListPackagistPackagesCommand extends Command
{
    protected static $defaultName = 'app:list-packagist-packages';

    /**
     * @var PackagistClient
     */
    private $packagistClient;

    protected function configure()
    {
        $this
            ->setDescription('List packages for a vendor')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Name of package vendor')
        ;
    }

    public function __construct(PackagistClient $packagistClient)
    {
        parent::__construct();
        $this->packagistClient = $packagistClient;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $vendor = $input->getArgument('vendor');

        $io->table(['Package'], array_map(function ($package) {
            return [$package];
        }, $this->packagistClient->getVendorPackages($vendor)));
    }
}
