<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Enums\ProblemTypeEnum;
use App\Enums\SourceEnum;
use App\Enums\StatusEnum;
use App\Repository\TicketRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Uuid;

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
            'denormalization_context' => [
                'groups' => [self::TICKET_WRITE]
            ]
        ],
        'get'
    ],
)]
#[ORM\HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: ['source' => 'exact', 'status' => 'exact', 'problemType' => 'exact', 'project.id' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
class Ticket
{
    private const TICKET_WRITE = 'ticket_write';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $lastName;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $phone;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $problemType;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $message;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tickets')]
    #[Groups(self::TICKET_WRITE)]
    private Collection $assign;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $source;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::TICKET_WRITE)]
    private string $status;

    #[ORM\ManyToOne(inversedBy: 'projectAssign')]
    #[Groups(self::TICKET_WRITE)]
    private Project $project;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(self::TICKET_WRITE)]
    private string $note;

    public function __construct()
    {
        $this->assign = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
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

    public function getStatus(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function setStatus(string|StatusEnum $status): self
    {
        $this->status = $status instanceof SourceEnum?
            $status->value:
            $status
        ;
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

}
