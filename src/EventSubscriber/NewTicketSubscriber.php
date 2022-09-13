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
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewTicketSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ChatterInterface $chatter,
        private HttpClientInterface $client,
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendTelegram', EventPriorities::POST_WRITE],
        ];
    }

    public function sendTelegram(ViewEvent $event, ChatterInterface $chatter): void
    {
        $ticket = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$ticket instanceof Ticket || Request::METHOD_POST !== $method) {
            return;
        }

        $result = $this->client->request(
            "GET",
            'https://api.telegram.org/bot5572129519:AAE-dVh7JZO3rKlCRgwM-XNaKWyICDRPmTo/getUpdates'
        )->toArray()['result'];

        foreach ($result as $message) {
            $telegramId = $message['message']['chat']['id'];
            $message = new ChatMessage(
                'Vas telegram bol sparovany s uctom v applikacii.Teraz budete dostavat notifikacie cez telegram.',
                new TelegramOptions(
                    [
                        'chat_id' => $telegramId
                    ]
                )
            );

            $this->chatter->send($message);
        }
    }
}
