<?php

namespace App\Entity;

use App\Enums\StatusEnum;
use App\Repository\StatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING , length: 255, unique: true)]
    private string $ticketStatus;

    #[ORM\Column(type: Types::INTEGER)]
    private int $ticketOrder;

    #[ORM\OneToOne(mappedBy: 'status', cascade: ['persist', 'remove'])]
    private ?TicketSettings $ticketSettings = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTicketStatus(): StatusEnum
    {
        return StatusEnum::from($this->ticketStatus);
    }

    public function setTicketStatus(string|StatusEnum $ticketStatus): self
    {
        $this->ticketStatus = $ticketStatus instanceof StatusEnum?
            $ticketStatus->value:
            $ticketStatus
        ;
        return $this;
    }

    public function getTicketOrder(): ?int
    {
        return $this->ticketOrder;
    }

    public function setTicketOrder(int $ticketOrder): self
    {
        $this->ticketOrder = $ticketOrder;

        return $this;
    }

    public function getTicketSettings(): ?TicketSettings
    {
        return $this->ticketSettings;
    }

    public function setTicketSettings(TicketSettings $ticketSettings): self
    {
        // set the owning side of the relation if necessary
        if ($ticketSettings->getStatus() !== $this) {
            $ticketSettings->setStatus($this);
        }

        $this->ticketSettings = $ticketSettings;

        return $this;
    }
}
