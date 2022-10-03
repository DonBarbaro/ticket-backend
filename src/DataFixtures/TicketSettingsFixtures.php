<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Entity\TicketSettings;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketSettingsFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UserTicketFixture::class
        ];
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < UsersFixtures::USER_COUNT; $i++) {

            /**
             * @var User $owner
             */
            $owner = $this->getReference(UsersFixtures::USER_REFERENCE . '_' . $i);
            for($j = 0; $j < StatusFixtures::STATUS_COUNT; $j++) {
                $ticketSettings = new TicketSettings();


                $ticketSettings->addOwner($owner);

                /**
                 * @var Status $status
                 */
                $status = $this->getReference(StatusFixtures::STATUS_REFERENCE.'_'.$j);
                $ticketSettings->addStatus($status);


                $manager->persist($ticketSettings);
            }
        }
        $manager->flush();
    }

}