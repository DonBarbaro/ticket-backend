<?php

namespace App\Entity;

use App\Enums\StatusEnum;
use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: TicketSettings::class, inversedBy: 'status')]
    private Collection $ticketSettings;

    public function __construct()
    {
        $this->ticketSettings = new ArrayCollection();
    }

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

    public function getTicketSettings(): Collection
    {
        return $this->ticketSettings;
    }

    public function addTicketSettings(TicketSettings $ticketSettings): self
    {
        if (!$this->ticketSettings->contains($ticketSettings)) {
            $this->ticketSettings->add($ticketSettings);
        }

        return $this;
    }

    public function removeTicketSettings(TicketSettings $ticketSettings): self
    {
        $this->ticketSettings->removeElement($ticketSettings);

        return $this;
    }
}
