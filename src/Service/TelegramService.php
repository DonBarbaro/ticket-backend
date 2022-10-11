<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Entity\TicketSettings;
use App\Entity\User;

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


    //TODO toto treba dorobit tu som prestal
    public function sendMessage(int $telegramId, Ticket $ticket): void
    {
        $this->telegramSender->sendMessage($telegramId, 'Ticket zmenil stav');
    }
}