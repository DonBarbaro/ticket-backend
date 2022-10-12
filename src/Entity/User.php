<?php

namespace App\Entity;

use ApiPlatform\Core\Action\PlaceholderAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\User\LoginInput;
use App\Dto\User\RegistrationInput;
use App\Entity\Embeddable\NotificationSettings;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        'login' => [
            'method' => 'POST',
            'path' => '/auth/login',
            'input' => LoginInput::class,
            'controller' => PlaceholderAction::class,
        ],
        'register' => [
            'method' => 'POST',
            'path' => '/auth/register',
            'input' => RegistrationInput::class,
            'security' => "is_granted('ROLE_ADMIN')",
            'security_message' => 'Only admins can register new users!',
        ],
        'get',
    ],
    itemOperations: [
        'get'
    ],
    normalizationContext: [
        'groups' => [self::READ]
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const READ = 'user:read';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::READ)]
    private string $email;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[Groups(self::READ)]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\ManyToMany(targetEntity: Ticket::class, mappedBy: 'assign')]
    #[Groups(self::READ)]
    private Collection $tickets;

    #[ORM\Embedded(class: NotificationSettings::class )]
    private NotificationSettings $notificationSettings;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'users')]
    #[JoinTable(name: "user_project")]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: TicketSettings::class)]
    private Collection $ticketSettings;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->roles = [];
        $this->projects = new ArrayCollection();
        $this->ticketSettings = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

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

    public function getNotificationSettings(): NotificationSettings
    {
        return $this->notificationSettings;
    }

    public function setNotificationSettings($notificationSettings): self
    {
        $this->notificationSettings = $notificationSettings;

        return $this;
    }

    public function getProject(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        $this->projects->removeElement($project);

        return $this;
    }

    public function getTicketSettings(): ?TicketSettings
    {
        return $this->ticketSettings;
    }

    public function setTicketSettings(TicketSettings $ticketSettings): self
    {
        // set the owning side of the relation if necessary
        if ($ticketSettings->getOwner() !== $this) {
            $ticketSettings->addOwner($this);
        }

        $this->ticketSettings = $ticketSettings;

        return $this;
    }

    /**
     * @return Collection<int, TicketSettings>
     */
    public function getTest1(): Collection
    {
        return $this->test1;
    }

    public function addTest1(TicketSettings $test1): self
    {
        if (!$this->test1->contains($test1)) {
            $this->test1->add($test1);
            $test1->setUser1($this);
        }

        return $this;
    }

    public function removeTest1(TicketSettings $test1): self
    {
        if ($this->test1->removeElement($test1)) {
            // set the owning side to null (unless already changed)
            if ($test1->getUser1() === $this) {
                $test1->setUser1(null);
            }
        }

        return $this;
    }

}
