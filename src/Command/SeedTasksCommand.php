<?php

namespace App\Command;

use App\Entity\Task;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedTasksCommand extends Command
{
    protected static $defaultName = 'app:seed-tasks';

    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Seed our tasks to expire "now" seconds')
            ->addArgument('number_of_tasks', InputArgument::REQUIRED, 'Number of tasks to seed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $howManyToSeed = $input->getArgument('number_of_tasks');
        $now = new \DateTime('now');

        for ($i = 0; $i < $howManyToSeed; $i++) {
            $task = new Task();
            $task->setName(uniqid());
            $task->setExpires($now);
            $this->objectManager->persist($task);
        }

        $this->objectManager->flush();
    }
}
