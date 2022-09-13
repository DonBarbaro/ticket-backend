<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Uuid;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'security' => "is_granted('ROLE_ADMIN')",
            'security_message' => 'Only admins can create create new project!'
        ],
        'get'
    ],
    itemOperations: [
        'get'
    ],
    denormalizationContext: [
        'groups' => self::PROJECT_WRITE
    ],
    normalizationContext: [
        'groups' => self::PROJECT_READ
    ]
)]
class Project
{
    public const PROJECT_READ = 'project:read';
    public const PROJECT_WRITE = 'project:write';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::PROJECT_WRITE, self::PROJECT_READ])]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::PROJECT_READ)]
    private string $projectToken;

    //toto som opravil 3
    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Ticket::class)]
    #[Groups(self::PROJECT_READ)]
    private Collection $tickets;

    //toto som opravil 1
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projects')]
    #[Groups(self::PROJECT_READ)]
    private Collection $users;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->projectToken = rtrim(strtr(base64_encode(random_bytes(50)), '+/', '-_'), '=');
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProjectToken(): ?string
    {
        return $this->projectToken;
    }

    public function setProjectToken(string $projectToken): self
    {
        $this->projectToken = $projectToken;

        return $this;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTickets(Ticket $tickets): self
    {
        if (!$this->tickets->contains($tickets)) {
            $this->tickets->add($tickets);
            $tickets->setProject($this);
        }

        return $this;
    }

    public function removeTickets(Ticket $tickets): self
    {
        if ($this->tickets->removeElement($tickets)) {
            // set the owning side to null (unless already changed)
            if ($tickets->getProject() === $this) {
                $tickets->setProject(null);
            }
        }
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(User $users): self
    {
        if (!$this->users->contains($users)) {
            $this->users->add($users);
            $users->addProject($this);
        }

        return $this;
    }

    public function removeUsers(User $users): self
    {
        if ($this->users->removeElement($users)) {
            $users->removeProject($this);
        }
        return $this;
    }
}
