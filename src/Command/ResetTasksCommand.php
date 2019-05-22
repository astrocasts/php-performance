<?php

namespace App\Command;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ResetTasksCommand extends Command
{
    protected static $defaultName = 'app:reset-tasks';

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(ObjectManager $objectManager, TaskRepository $taskRepository)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
        $this->taskRepository = $taskRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Reset expired tasks')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $now = new \DateTime('now');
        $newExpires = new \DateTime('now + 5 seconds');

        $counter = 0;

        while (true) {
            /** @var Task[] $expiredTasks */
            $expiredTasks = $this->taskRepository->findExpiredTasksSince(
                $now,
                100
            );

            if (! count($expiredTasks)) {
                break;
            }

            foreach ($expiredTasks as $expiredTask) {
                $expiredTask->reset($newExpires);
                $this->objectManager->flush();
                $counter++;
            }
            $io->note(' ... reset ' . $counter . ' tasks');
        }

        $io->success('You have reset all tasks!');
    }
}
