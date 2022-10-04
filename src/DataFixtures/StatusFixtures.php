<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{

    public const STATUS_REFERENCE = 'status';
    public const STATUS_COUNT = 3;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < self::STATUS_COUNT; $i++) {
            $status = new Status();
            switch ($i) {
                case 0:
                    $status->setTicketStatus("New");
                    break;
                case 1:
                    $status->setTicketStatus("Progress");
                    break;
                default:
                    $status->setTicketStatus("Solved");
                    break;
            }
            $status->setTicketOrder($i);
            $this->addReference(self::STATUS_REFERENCE.'_'.$i,$status);

            $manager->persist($status);
        }
        $manager->flush();
    }
}