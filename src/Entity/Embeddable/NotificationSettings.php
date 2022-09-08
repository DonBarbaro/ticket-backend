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

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $push = false;

    public function getTelegramId(): string
    {
        return $this->telegramId;
    }

    public function setTelegramId(string $telegramId): NotificationSettings
    {
        $this->telegramId = $telegramId;
        return $this;
    }

    public function isTelegramVerified(): bool
    {
        return $this->telegramVerified;
    }

    public function setTelegramVerified(bool $telegramVerified): NotificationSettings
    {
        $this->telegramVerified = $telegramVerified;
        return $this;
    }


    public function getEmailId(): string
    {
        return $this->emailId;
    }

    public function setEmailId(string $emailId): NotificationSettings
    {
        $this->emailId = $emailId;
        return $this;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function setEmailVerified(bool $emailVerified): NotificationSettings
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }

    public function isPush(): bool
    {
        return $this->push;
    }

    public function setPush(bool $push): NotificationSettings
    {
        $this->push = $push;
        return $this;
    }
}