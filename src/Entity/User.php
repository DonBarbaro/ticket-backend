<?php

namespace App\Entity;

use ApiPlatform\Core\Action\PlaceholderAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Api\Action\RegisterAction;
use App\Dto\InputDto\LoginInputDto;
use App\Dto\InputDto\RegistrationInputDto;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        'login' => [
            'method' => 'POST',
            'path' => '/auth/login',
            'input' => LoginInputDto::class,
            'controller' => PlaceholderAction::class,
        ],
        'register' => [
            'method' => 'POST',
            'path' => '/auth/register',
            'controller' => RegisterAction::class,
            'input' => RegistrationInputDto::class,
            'security' => "is_granted('ROLE_ADMIN')",
            'security_message' => 'Only admins can register new users!',
        ],
        'get',
    ],
    itemOperations: ['get'],
    normalizationContext: [
        'groups' => [self::READ]
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const READ = 'user:read';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::READ)]
    private string $email;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[Groups(self::READ)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\ManyToMany(targetEntity: Ticket::class, mappedBy: 'assign')]
    #[Groups(self::READ)]
    private Collection $tickets;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'userProject')]
    private Collection $project;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->roles = [];
        $this->project = new ArrayCollection();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }


    public function getUserIdentifier(): Uuid
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->addAssign($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            $ticket->removeAssign($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProjectAssign(Project $projectAssign): self
    {
        if (!$this->project->contains($projectAssign)) {
            $this->project->add($projectAssign);
        }

        return $this;
    }

    public function removeProjectAssign(Project $projectAssign): self
    {
        $this->project->removeElement($projectAssign);

        return $this;
    }

}
