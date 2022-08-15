<?php

declare(strict_types=1);

namespace App\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Serializer\Annotation\Groups;

trait Identified
{
    #[
        ORM\Id,
        ORM\Column(type: "uuid", unique: true),
        ORM\GeneratedValue(strategy: "CUSTOM"),
        ORM\CustomIdGenerator(class: UuidGenerator::class)
    ]
    #[Groups([AttributesGroups::ID, AttributesGroups::ALL])]
    protected UuidInterface $id;

    public function getId(): UuidInterface
    {
        $this->id ??= Uuid::uuid4();
        return $this->id;
    }

    public function setId(UuidInterface|string|null $id = null)
    {
        if (isset($this->id)) {
            throw new BadRequestException('ID is already set');
        }
        if (!$id instanceof UuidInterface) {
            $this->id = $id ? Uuid::fromString($id) : Uuid::uuid4();
        } else {
            $this->id = $id;
        }
    }

    public function __clone()
    {
        $this->id = Uuid::uuid4();
    }

}
