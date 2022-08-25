<?php

namespace App\Dto\InputDto;

use App\Entity\Project;
use App\Entity\Ticket;
use App\Entity\User;
use App\Enums\ProblemTypeEnum;
use App\Enums\SourceEnum;
use App\Enums\StatusEnum;
use Doctrine\Common\Collections\Collection;

class TicketInputDto
{
    public string $firstName;

    public string $lastName;

    public string $email;

    public string $phone;

    public string $problemType;

    public string $message;

    public User $assign;

    public string $source;

    public string $status;

    public Project $project;

    public string $note;

    public static function toTicket(TicketInputDto $object): Ticket
    {
        return (new Ticket())
            ->setFirstName($object->firstName)
            ->setEmail($object->email)
            ->setLastName($object->lastName)
            ->setPhone($object->phone)
            ->setProblemType($object->problemType)
            ->setMessage($object->message)
            ->addAssign($object->assign)
            ->setSource($object->source)
            ->setStatus($object->status)
            ->setProject($object->project)
            ->setNote($object->note);
    }
}