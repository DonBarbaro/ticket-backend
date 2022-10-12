<?php

namespace App\Entity;

use App\Repository\TicketSettingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TicketSettingsRepository::class)]


class TicketSettings
{


    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'ticketSettings')]
    private Status $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ticketSettings')]
    private User $owner;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'ticketSettings')]
    private Ticket $ticket;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private bool $email;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private bool $telegram;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getOwner(): Collection
    {
        return $this->owners;
    }

    public function addOwner(User $user): self
    {
        if (!$this->owners->contains($user)) {
            $this->owners->add($user);
        }

        return $this;
    }

    public function removeOwner(User $owner): self
    {
        $this->owners->removeElement($owner);

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): TicketSettings
    {
        $this->status = $status;
        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): TicketSettings
    {
        $this->owner = $owner;
        return $this;
    }

    public function isEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(?bool $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isTelegram(): ?bool
    {
        return $this->telegram;
    }

    public function setTelegram(?bool $telegram): self
    {
        $this->telegram = $telegram;

        return $this;
    }



}
