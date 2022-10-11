<?php

namespace App\Entity;

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

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'statuses')]
    private Project $project;

    #[ORM\Column(type: Types::STRING , length: 255)]
    private string $label;

    #[ORM\Column(type: Types::STRING , length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $orderIndex;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: TicketSettings::class)]
    private Collection $ticketSettings;

    public function __construct()
    {
        $this->ticketSettings = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getLabel(): String
    {
        return $this->label;
    }
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }
    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project):self
    {
        $this->project = $project;
        return $this;
    }
    public function getName(): ?String
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }
    public function setOrderIndex(int $orderIndex): self
    {
        $this->orderIndex = $orderIndex;
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
