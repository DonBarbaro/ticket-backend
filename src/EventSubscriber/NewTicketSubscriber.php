<?php

namespace App\EventSubscriber;

use App\Entity\Ticket;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class NewTicketSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private NotifierInterface $notifier
    )
    {}

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

        $notification = new Notification();
        $notification->content('Dostal si novy ticket od '.$ticket->getEmail());
        $notification->importance(Notification::IMPORTANCE_HIGH);
        $notification->channels(['chat/telegram']);

        $this->notifier->send($notification);
    }
}