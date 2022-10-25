<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Api\Dto\Ticket\TicketInputDto;
use App\Enums\ProblemTypeEnum;
use App\Enums\SourceEnum;
use App\Repository\TicketRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'denormalization_context' => [
                'groups' => [self::TICKET_WRITE]
            ]
        ],
        'get'
    ],
    itemOperations: [
        'put' => [
            'method' => 'PUT',
            'input' => TicketInputDto::class,
        ],
        'get'
    ],
    normalizationContext: [self::TICKET_READ]
)]
#[ORM\HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: ['source' => 'exact', 'status' => 'exact', 'problemType' => 'exact', 'project.id' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
class Ticket
{
    private const TICKET_WRITE = 'ticket_write';
    private const TICKET_READ = 'ticket_read';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    #[Groups(self::TICKET_READ)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $lastName;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $phone;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $problemType;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $message;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tickets')]
    #[Groups(self::TICKET_WRITE)]
    #[MaxDepth(1)]
    private Collection $assign;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private string $source;

    #[ORM\ManyToOne(targetEntity: Status::class, cascade: ['persist'], inversedBy: 'tickets')]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private Status $status;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups([self::TICKET_WRITE, self::TICKET_READ])]
    private Project $project;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(self::TICKET_WRITE)]
    private string $note;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: TicketSettings::class)]
    #[MaxDepth(1)]
    private Collection $ticketSettings;

    public function __construct()
    {
        $this->assign = new ArrayCollection();
        $this->ticketSettings = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProblemType(): ProblemTypeEnum
    {
        return ProblemTypeEnum::from($this->problemType);
    }

    public function setProblemType(string|ProblemTypeEnum $problemType): self
    {
        $this->problemType = $problemType instanceof ProblemTypeEnum?
            $problemType->value:
            $problemType
        ;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAssign(): Collection
    {
        return $this->assign;
    }

    public function addAssign(User $assign): self
    {
        if (!$this->assign->contains($assign)) {
            $this->assign->add($assign);
        }

        return $this;
    }

    public function removeAssign(User $assign): self
    {
        $this->assign->removeElement($assign);

        return $this;
    }

    public function getSource(): SourceEnum
    {
        return SourceEnum::from($this->source);
    }


    public function setSource(string|SourceEnum $source): self
    {
        $this->source = $source instanceof SourceEnum?
            $source->value:
            $source
        ;
        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): Ticket
    {
//        $this->status->removeTicket($this);
//        $status->addTicket($this);
        $this->status = $status;
        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTicketSettings(): Collection
    {
        return $this->ticketSettings;
    }

    public function addTicket(TicketSettings $ticketSettings): self
    {
        if (!$this->ticketSettings->contains($ticketSettings)) {
            $this->ticketSettings->add($ticketSettings);
        }

        return $this;
    }

    public function removeTicket(TicketSettings $ticketSettings): self
    {
        $this->ticketSettings->removeElement($ticketSettings);

        return $this;
    }

}
