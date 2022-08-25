<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource(

)]
class Project
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ApiProperty(identifier: true)]
    private UuidInterface $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $projectToken;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Ticket::class)]
    private Collection $projectAssign;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projectAssign')]
    private Collection $userProject;

    public function __construct(UuidInterface $id = null)
    {
        $this->id= $id ?: Uuid::uuid4();
        $this->projectAssign = new ArrayCollection();
        $this->userProject = new ArrayCollection();
    }

    public function getId(): UuidInterface
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
