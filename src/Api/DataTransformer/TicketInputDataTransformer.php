<?php

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Api\Dto\Ticket\TicketInputDto;
use App\Entity\Ticket;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TicketInputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): Ticket
    {
        /**
         * @var Ticket $ticket
         */

        $ticket = $context[AbstractNormalizer::OBJECT_TO_POPULATE];
//        $ticket->setFirstName($object->firstName);
//        $ticket->setLastName($object->lastName);
//        $ticket->setEmail($object->email);
//        $ticket->setPhone($object->phone);
//        $ticket->setProblemType($object->problemType);
//        $ticket->setMessage($object->message);
//        $ticket->setSource($object->source);
        $ticket->setStatus($object->status);
//        $ticket->setProject($object->project);
//        $ticket->setNote($object->note);

        return $ticket;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Ticket)
        {
            return false;
        }
        return Ticket::class === $to && null !== ($context['input']['class'] ?? null);
    }
}