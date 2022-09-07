<?php

declare(strict_types=1);

namespace App\Entity\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class NotificationSettings
{
    #[ORM\Column(type: Types::STRING)]
    private string $telegramId;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $telegramVerified = false;

    #[ORM\Column(type: Types::STRING)]
    private string $emailId;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $emailVerified = false;

    private bool $push = true;
}