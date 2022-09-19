<?php

namespace App\Command;

use App\Service\TelegramSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:send')]
class SendTelegram extends Command
{
    public function __construct(
        private TelegramSender $telegramSender
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->telegramSender->sendMessage('5336884988', 'Ahoj, bol ti pridelený nový problem.');
        return Command::SUCCESS;
    }
}