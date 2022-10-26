<?php

namespace App\Api\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Ticket;

class NewTicketDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(private ContextAwareDataPersisterInterface $decorated)
    {
    }


    public function supports($data, array $context = []): bool
    {
        return $data instanceof Ticket;
    }

    public function persist($data, array $context = [])
    {
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}