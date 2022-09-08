<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:send-telegram')]
class SendTelegram extends Command
{
    protected static $defaultName = 'app:send-telegram';

    public function __construct(private ChatterInterface $chatter)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chatMessage = (new ChatMessage('Ahoj kraska'))
            ->transport('chat/telegram')
        ;

        $telegramOptions = (new TelegramOptions())
            ->chatId(5720843129)
        ;

        $chatMessage->options($telegramOptions);
        $this->chatter->send($chatMessage);
    return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}