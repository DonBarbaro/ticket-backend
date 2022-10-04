<?php

namespace App\Service;

use App\Entity\Embeddable\NotificationSettings;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\TicketSettings;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TelegramService $telegramService
    )
    {
    }

    public function statusChangedNotification(Ticket $ticket): void
    {
        /**
         * @var User $users
         */
        $users = $ticket->getAssign()->toArray();
        $status = $this->entityManager->getRepository(Status::class)->findOneBy(['ticketStatus'=>$ticket->getStatus()]);
        $ticketSettingsRepo = $this->entityManager->getRepository(TicketSettings::class);

        $ticketSettings = $ticketSettingsRepo->findByTicket((array)$users, $ticket, null);
        $statusSettings = $ticketSettingsRepo->findByTicket((array)$users, null, $status);

        $settings = array_merge($statusSettings, $ticketSettings);

        /**
         * @var TicketSettings $setting
         */
        foreach ($settings as $setting){
                if ($setting->isTelegram()){
                    $this->telegramService->sendMessage($setting, $ticket);
                }
            }
        }

}