<?php

namespace App\Service;

use App\Entity\User;

class EmailService
{
    public function __construct(private EmailSender $emailSender)
    {
    }

    public function newTicketMessage($users): void
    {
        /**
         * @var User $user
         */
        array_map(function (User $user) {
            if ($user->getNotificationSettings()->isEmailVerified()) {

                $payload = [
                    'subject1' => "nejaky nazov",
                    'meno' => "hej, tu je Ferdo"
                ];

                $this->emailSender->sendEmail($user->getEmail(), 'd-14cb2d0b076240459ef443edb0638e70', $payload);
            }
        }, $users);
    }


}