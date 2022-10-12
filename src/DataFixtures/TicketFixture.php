<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixture extends Fixture implements DependentFixtureInterface
{

    public const TICKET_REFERENCE = 'ticket';
    public const TICKET_COUNT = 3;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UsersFixtures::USER_COUNT; $i++){
            /**
             * @var User $user
             */
            $user = $this->getReference(UsersFixtures::USER_REFERENCE.'_'.$i);
            for($j = 0; $j < self::TICKET_COUNT; $j++) {
                $ticket = new Ticket();
                $ticket->setFirstName("NewTicket_".(self::TICKET_COUNT*$i + $j));
                $ticket->setLastName("TicketLastName_".(self::TICKET_COUNT*$i + $j));
                $ticket->setEmail("ticket".(self::TICKET_COUNT*$i + $j)."@mailinator.com");
                $ticket->setPhone((string) random_int(1000000,10000000));
                $ticket->setProblemType($this->randomProblemType());
                $ticket->setMessage("SomeRandomTextForMessage".(self::TICKET_COUNT*$i + $j));
                $ticket->setSource($this->randomSource());
                $ticket->setStatus($this->getReference(StatusFixtures::STATUS_REFERENCE.'_0'));

                /**
                 * @var Project $project
                 */
                $project = $this->getReference(ProjectFixtures::PROJECT_REFERENCE.'_'.($i%2));
                $ticket->setProject($project);
                $ticket->setNote("RandomNote".(self::TICKET_COUNT*$i + $j));
                $user->addTicket($ticket);
                $this->addReference(self::TICKET_REFERENCE.'_'.(self::TICKET_COUNT*$i + $j), $ticket);

                $manager->persist($ticket);
            }
        }

        $manager->flush();
    }

    public function randomProblemType(): string{
        return match (random_int(0, 1)) {
            0 => "Program",
            default => "Economy",
        };
    }

    public function randomSource(): string {
        return match (random_int(0, 1)) {
            0 => "Customer",
            default => "Support",
        };
    }

    public function randomStatus(): string{
        return match (random_int(0, 2)) {
            0 => "New",
            1 => "Progress",
            default => "Solved",
        };
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            StatusFixtures::class
        ];
    }
}