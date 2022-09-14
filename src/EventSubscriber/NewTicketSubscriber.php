<?php

namespace App\EventSubscriber;

use App\Entity\Ticket;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewTicketSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendTelegram', EventPriorities::POST_WRITE],
        ];
    }

    public function sendTelegram(ViewEvent $event, ChatterInterface $chatter, HttpClientInterface $client): void
    {
        $ticket = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$ticket instanceof Ticket || Request::METHOD_POST !== $method) {
            return;
        }

        $result = $client->request(
            "GET",
            'https://api.telegram.org/bot5720843129:AAHre4fDqLhgxvmoiLqmrcL8YiVv-pi6KXQ/getUpdates'
        )->toArray()['result'];

        foreach ($result as $message) {
            $telegramId = $message['message']['chat']['id'];
            $message = new ChatMessage(
                'Nový ticket '.$ticket->getProject().' bol vytvoreny',
                new TelegramOptions(
                    [
                        'chat_id' => $telegramId
                    ]
                )
            );

            $chatter->send($message);
        }
    }
}
