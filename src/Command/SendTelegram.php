<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:send')]
class SendTelegram extends Command
{
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
            'https://api.telegram.org/bot5720843129:AAHre4fDqLhgxvmoiLqmrcL8YiVv-pi6KXQ/getUpdates'
        )->toArray()['result'];

        foreach ($result as $message) {
            $telegramId = $message['message']['chat']['id'];
            $message = new ChatMessage(
                'Ako sa mas',
                new TelegramOptions(
                    [
                        'chat_id' => $telegramId
                    ]
                )
            );
            $this->chatter->send($message);
            dd($message);
        }

        return Command::SUCCESS;

    }
}