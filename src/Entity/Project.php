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
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::PROJECT_WRITE, self::PROJECT_READ])]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(self::PROJECT_READ)]
    private string $projectToken;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Ticket::class)]
    #[Groups(self::PROJECT_READ)]
    private Collection $projectAssign;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'project')]
    private Collection $userProject;

    public function __construct(UuidInterface $id = null)
    {
        $this->projectAssign = new ArrayCollection();
        $this->projectToken = rtrim(strtr(base64_encode(random_bytes(50)), '+/', '-_'), '=');
        $this->userProject = new ArrayCollection();
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

    /**
     * @return Collection<int, Ticket>
     */
    public function getProjectAssign(): Collection
    {
        return $this->projectAssign;
    }

    public function addProjectAssign(Ticket $projectAssign): self
    {
        if (!$this->projectAssign->contains($projectAssign)) {
            $this->projectAssign->add($projectAssign);
            $projectAssign->setProject($this);
        }

        return $this;
    }

    public function removeProjectAssign(Ticket $projectAssign): self
    {
        if ($this->projectAssign->removeElement($projectAssign)) {
            // set the owning side to null (unless already changed)
            if ($projectAssign->getProject() === $this) {
                $projectAssign->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserProject(): Collection
    {
        return $this->userProject;
    }

    public function addUserProject(User $userProject): self
    {
        if (!$this->userProject->contains($userProject)) {
            $this->userProject->add($userProject);
            $userProject->addProjectAssign($this);
        }

        return $this;
    }

    public function removeUserProject(User $userProject): self
    {
        if ($this->userProject->removeElement($userProject)) {
            $userProject->removeProjectAssign($this);
        }

        return $this;
    }
}
