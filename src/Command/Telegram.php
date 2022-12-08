<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'app:send')]
class Telegram extends Command
{
    // the name of the command (the part after "bin/console")
    public function __construct(
        private ChatterInterface    $chatter,
        private HttpClientInterface $client,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->client->request(
            "GET",
            'https://api.telegram.org/bot5680388670:AAHmr25f_vv67ZReTMzFkpKvBHdO86d928s/getUpdates'
        )->toArray()['result'];

        foreach ($result as $message) {
            $telegramId = $message['message']['chat']['id'];
            $message = new ChatMessage(
                'Nazdarek',
                new TelegramOptions(
                    [
                        'chat_id' => $telegramId
                    ]
                )
            );
            $this->chatter->send($message);
        }
        return Command::SUCCESS;
    }
}