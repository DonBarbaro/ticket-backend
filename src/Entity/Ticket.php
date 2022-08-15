<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Enums\ProblemTypeEnum;
use App\Enums\SourceEnum;
use App\Enums\StatusEnum;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource]
class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    #[ApiProperty(identifier: true)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $phone;

    #[ORM\Column(type: 'string', length: 255, enumType: ProblemTypeEnum::class)]
    private string $problemType;

    #[ORM\Column(type: 'string', length: 255)]
    private string $message;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tickets')]
    private Collection $assign;

    #[ORM\Column(type: 'string', length: 255, enumType: SourceEnum::class)]
    private string $source;

    #[ORM\Column(type: 'string', length: 255, enumType: StatusEnum::class)]
    private string $status;

    #[ORM\ManyToOne(inversedBy: 'projectAssign')]
    private Project $project;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;


    public function __construct(UuidInterface $id = null)
    {
        $this->id = Uuid::uuid4();
        $this->assign = new ArrayCollection();
    }

    public function getId(): UuidInterface
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

    public function getProblemType(): ?string
    {
        return $this->problemType;
    }

    public function setProblemType(string $problemType): self
    {
        $this->problemType = $problemType;

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

    public function getSource(): ?string
    {
        return $this->source;
    }


    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
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

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}