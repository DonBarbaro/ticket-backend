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

    #[ORM\ManyToMany(targetEntity: Status::class, mappedBy: 'ticketSettings')]
    private Collection $status;

    #[ORM\OneToMany(mappedBy: 'ticketSettings', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $owners;

    #[ORM\ManyToMany(targetEntity: Ticket::class, mappedBy:  'ticketSettings')]
    private Collection $tickets;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private bool $email;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private bool $telegram;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->status = new ArrayCollection();
        $this->owners = new ArrayCollection();
    }

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

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        $this->tickets->removeElement($ticket);

        return $this;
    }

    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->status->contains($status)) {
            $this->status->add($status);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        $this->status->removeElement($status);

        return $this;
    }
}
