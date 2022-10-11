<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Ticket;
use App\Service\EmailService;
use App\Service\TelegramService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;


class NewTicketSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EmailService $emailService,
        private TelegramService $telegramService
    )
    {}

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['newTicketMessage', EventPriorities::POST_WRITE],
        ];
    }

    public function newTicketMessage(ViewEvent $event)
    {
        $method = $event->getRequest()->getMethod();
        $ticket = $event->getControllerResult();
        if (!$ticket instanceof Ticket || Request::METHOD_POST !== $method) {
            return;
        }
        $users = $ticket->getProject()->getUsers()->toArray();
        $this->emailService->newTicketMessage($users);
        $this->telegramService->newTicketMessage($users);
    }
}
