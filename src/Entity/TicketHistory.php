<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Repository\TicketHistoryRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TicketHistoryRepository::class)]
class TicketHistory
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\JoinTable(name: 'ticket_ticket_histories')]
    #[ORM\JoinColumn(name: 'ticket_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'ticket_histories_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Ticket::class, inversedBy: 'ticketHistories')]
    private Collection $ticket;

    #[ORM\Column(length: 255)]
    private string $event;

    #[ORM\Column(length: 255)]
    private string $payload;

    #[ORM\JoinTable(name: 'user_ticket_histories')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'user_histories_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $userUpdate;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function __construct()
    {
        $this->ticket = new ArrayCollection();
        $this->userUpdate = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket->add($ticket);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        $this->ticket->removeElement($ticket);

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getUserUpdate(): Collection
    {
        return $this->userUpdate;
    }

    public function addUserUpdate(User $userUpdate): self
    {
        if (!$this->userUpdate->contains($userUpdate)) {
            $this->userUpdate->add($userUpdate);
        }

        return $this;
    }

    public function removeUserUpdate(User $userUpdate): self
    {
        $this->userUpdate->removeElement($userUpdate);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }
}
