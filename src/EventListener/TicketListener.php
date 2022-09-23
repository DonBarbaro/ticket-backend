<?php

namespace App\EventListener;

use App\Entity\Ticket;

use App\Service\NotificationService;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TicketListener
{
    public function __construct(
        private NotificationService $settings
    )
    {}

    public function preUpdate(Ticket $ticket, PreUpdateEventArgs $eventArgs): void
    {
        if ($eventArgs->hasChangedField('status')) {
            $this->settings->statusChangedNotification($ticket);
        }
    }
}