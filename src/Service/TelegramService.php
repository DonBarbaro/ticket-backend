<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Entity\TicketSettings;
use App\Entity\User;
use App\Enums\StatusEnum;

class TelegramService
{
    public function __construct(
        private TelegramSender $telegramSender,
    )
    {}

    public function newTicketMessage($users): void
    {
        /**
         * @var User $user
         */
        array_map(function (User $user) {
            if ($user->getNotificationSettings()->isTelegramVerified()) {
                $this->telegramSender->sendMessage($user->getNotificationSettings()->getTelegramId(), 'Novy ticket');
            }
        }, $users);
    }

    public function getMessageByStatus(Ticket $ticket): string
    {
        return match ($ticket->getStatus()->value) {
            StatusEnum::Progress->value => 'Ticket '.$ticket->getId().' je v procese spracovania',
            StatusEnum::WaitingForReply->value => 'Ticket '.$ticket->getId().' caka na overenie',
            StatusEnum::Solved->value => 'Ticket '.$ticket->getId().' bol uspesne vyrieseny',
            StatusEnum::New->value => 'Ticket '.$ticket->getId().' bol pridany',
        };
    }

    public function sendMessage(TicketSettings $settings, Ticket $ticket): void
    {
        $this->telegramSender->sendMessage($settings->getOwner()->getNotificationSettings()->getTelegramId(), $this->getMessageByStatus($ticket));
    }
}