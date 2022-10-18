<?php

namespace App\Api\Dto\Ticket;

use App\Entity\Project;
use App\Entity\Status;
use Doctrine\Common\Collections\Collection;

class TicketInputDto
{
    public string $id;

    public string $firstName;

    public string $lastName;

    public string $email;

    public string $phone;

    public string $problemType;

    public string $message;

    public Collection $assign;

    public string $source;

    public Status $status;

    public Project $project;

    public string $note;

}