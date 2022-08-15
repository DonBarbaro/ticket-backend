<?php

declare(strict_types=1);

namespace App\Entity\Attributes;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Exception;

class UuidGenerator extends AbstractIdGenerator
{
    /**
     * Generate an identifier only if it is not set
     *
     * @throws Exception
     */
    public function generate(EntityManager $em, $entity): UuidInterface
    {
        return $entity->getId() ?? Uuid::uuid4();
    }
}
