<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;


#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'denormalization_context' => [
                'groups' => [self::COMMENT_WRITE]
            ],


        ],
        'get' => [
            'normalization_context' => [
                'groups' => [self::COMMENT_READ]
            ]
        ]
    ],
    itemOperations: [
        'put',
        'get'
    ]
)]

#[ApiFilter(SearchFilter::class, properties: ["ticket.id" => "exact"])]
class Comment
{
    public const COMMENT_READ = 'comment:read';
    public const COMMENT_WRITE = 'comment:write';


    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private User $author;

    #[ORM\Column(type: Types::STRING)]
    #[Groups([self::COMMENT_WRITE, self::COMMENT_READ])]
    private string $commentMessage;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'subComments')]
    #[Groups(self::COMMENT_WRITE)]
    private Comment $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Comment::class)]
    #[ORM\JoinColumn(name: "subComment", referencedColumnName: "id")]
    #[Groups(self::COMMENT_READ)]
    private Collection $subComments;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'comments')]
    #[Groups(self::COMMENT_WRITE)]
    private Ticket $ticket;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true,options: ['default' => null])]
    private ?DateTime $deletedAt;


    public function __construct()
    {
        $this->id = new UuidV4();
        $this->subComments = new ArrayCollection();
        $this->setCommentMessage('Daco');
    }


    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }


    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }


    public function getCommentMessage(): string
    {
        return $this->commentMessage;
    }


    public function setCommentMessage(string $commentMessage): self
    {
        $this->commentMessage = $commentMessage;
        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;
        return $this;
    }


    public function getSubComments(): Collection
    {
        return $this->subComments;
    }

    public function addSubComment(Comment $subComment): self
    {
        if(!$this->subComments->contains($subComment)){
            $this->subComments->add($subComment);
        }

        return $this;
    }

    public function removeSubComment(Comment $subComment): self
    {
        $this->subComments->removeElement($subComment);

        return $this;
    }


    public function getParent(): Comment
    {
        return $this->parent;
    }


    public function setParent(Comment $parent): Comment
    {
        $this->parent = $parent;
        return $this;
    }

}