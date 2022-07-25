<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Virtua\ShopwareAppLoggerBundle\Service\LogsCleaner;

class CleanLogs extends Command
{
    public const COMMAND_NAME = 'Old logs cleaner';

    protected static $defaultName = 'virtua:logs:clean';

    private LogsCleaner $appLogCleaner;

    public function __construct(LogsCleaner $appLogCleaner)
    {
        $this->appLogCleaner = $appLogCleaner;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription(
            'Clean logs older than 30 days.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->appLogCleaner->cleanOldLogs();

            $io->success('Successfully cleaned all logs.');
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
        }

        return 0;
    }
}
