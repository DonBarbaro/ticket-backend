<?php

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\TicketInputDto;
use App\Entity\Ticket;

class TicketInputDataTransformer implements DataTransformerInterface
{
    /**
     * @param TicketInputDto $object
     */
    public function transform($object, string $to, array $context = []): Ticket
    {
        return TicketInputDto::toTicket($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Ticket) {
            return false;
        }

        return Ticket::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
