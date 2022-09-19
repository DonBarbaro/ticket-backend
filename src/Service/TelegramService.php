<?php

namespace App\Service;

use App\Entity\Ticket;
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
}