<?php

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Api\Dto\Ticket\TicketInputDto;
use App\Entity\Ticket;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TicketInputDataTransformer implements DataTransformerInterface
{
    /**
     * @param TicketInputDto $object
     */
    public function transform($object, string $to, array $context = []): Ticket
    {
        /**
         * @var Ticket $ticket
         */
        $ticket = $context[AbstractNormalizer::OBJECT_TO_POPULATE];
        $object->firstName == null ? : $ticket->setFirstName($object->firstName);
        $object->lastName == null ? : $ticket->setLastName($object->lastName);
        $object->email == null ? : $ticket->setEmail($object->email);
        $object->phone == null ? : $ticket->setPhone($object->phone);
        $object->problemType == null ? : $ticket->setProblemType($object->problemType);
        $object->message == null ? : $ticket->setMessage($object->message);
        $object->source == null ? : $ticket->setSource($object->source);
        $object->status == null ? : $ticket->setStatus($object->status);
        $object->project == null ? : $ticket->setProject($object->project);
        $object->note == null ? : $ticket->setNote($object->note);

        return $ticket;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Ticket) {
            return false;
        }
        return Ticket::class === $to && null !== ($context['input']['class'] ?? null);
    }


}