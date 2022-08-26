<?php

declare(strict_types=1);

namespace App\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class NotificationSettings
{
    #[ORM\Column(type: 'string')]
    private string $telegramId;

    #[ORM\Column(type: 'boolean')]
    private bool $telegramVarified = true;

    #[ORM\Column(type: 'string')]
    private string $emailId;

    #[ORM\Column(type: 'boolean')]
    private bool $emailVarified = true;

    private bool $push = true;
}