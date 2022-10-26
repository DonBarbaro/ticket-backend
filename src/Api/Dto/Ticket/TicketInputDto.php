<?php

namespace App\Api\Dto\Ticket;

use App\Entity\Project;
use App\Entity\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TicketInputDto
{
    public ?string $id = null;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $problemType = null;

    public ?string $message = null;

    public Collection $assign;

    public ?string $source = null;

    public ?Status $status = null;

    public ?Project $project = null;

    public ?string $note = null;

    public function __construct()
    {
        $this->assign = new ArrayCollection();
    }
}