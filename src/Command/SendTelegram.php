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
//        $response = $this->client->request('GET', 'https://api.telegram.org/bot5720843129:AAH52XiquaqC7FVefO07azM5GN4mvl4OVMU/getUpdates');
//        $content = $response->toArray();
//
//        $chatMessage = (new ChatMessage('Ahoj kraska'))
//        ;
//        $telegramOptions = (new TelegramOptions())
//            ->chatId(5336884988)
//        ;
//        $chatMessage->options($telegramOptions);
//        $this->chatter->send($chatMessage);
        $result = $this->client->request(
            "GET",
            'https://api.telegram.org/bot5680388670:AAHmr25f_vv67ZReTMzFkpKvBHdO86d928s/getUpdates'
        )->toArray()['result'];

        foreach ($result as $message) {
            $telegramId = $message['message']['chat']['id'];
            $message = new ChatMessage(
                'AHoj',
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