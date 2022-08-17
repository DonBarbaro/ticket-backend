<?php

namespace App\Dto\OutputDto;

use App\Entity\Project;
use Doctrine\Common\Collections\Collection;

class TicketOutputDto
{
    public string $firstname;

    public string $lastName;

    public string $email;

    public string $phone;

    public string $problemType;

    public string $message;

    public Collection $assign;

    public string $source;

    public string $status;

    public Project $project;
}