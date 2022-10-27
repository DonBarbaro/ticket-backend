<?php

namespace App\EventListener;

use App\Entity\Ticket;

use App\Service\NotificationService;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TicketListener
{
    public function __construct(
        private NotificationService $notificationService
    )
    {}

    public function preUpdate(Ticket $ticket, PreUpdateEventArgs $eventArgs): void
    {
        if ($eventArgs->hasChangedField('status') && $eventArgs->getOldValue('status') !== null)
        {
            $this->notificationService->statusChangedNotification($ticket);
        }
    }
}