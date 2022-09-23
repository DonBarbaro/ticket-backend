<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\TicketSettings;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TelegramSender $sender
    )
    {
    }

    public function statusChangedNotification(Ticket $ticket){
        /**
         * @var User $users
         */
        $users = $ticket->getAssign()->toArray();
        $status = $this->entityManager->getRepository(Status::class)->findOneBy(['ticketStatus'=>$ticket->getStatus()]);
        $ticketSettingsRepo = $this->entityManager->getRepository(TicketSettings::class);
        $ticketSettings = $ticketSettingsRepo->findByTicket($users, $ticket, null);
        $statusSettings = $ticketSettingsRepo->findByTicket($users, null, $status);

        $settings = array_merge($statusSettings, $ticketSettings);

        }

}