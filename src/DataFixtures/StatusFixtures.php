<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture implements DependentFixtureInterface
{
    public const STATUS_REFERENCE = 'status';
    public const STATUS_COUNT = 6;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < self::STATUS_COUNT; $i++) {
            $status = new Status();

            /**
             *@var Project $project
             */
            $project = $this->getReference(ProjectFixtures::PROJECT_REFERENCE.'_'.random_int(0, (ProjectFixtures::PROJECT_COUNT - 1)));
            $status->setProject($project);
            switch ($i % 3) {
                case 0:
                    $status->setName("New");
                    $status->setLabel("new");
                    break;
                case 1:
                    $status->setName("Progress");
                    $status->setLabel("progress");
                    break;
                default:
                    $status->setName("Solved");
                    $status->setLabel("solved");
                    break;
            }
            $status->setOrderIndex($i % 3);
            $this->addReference(self::STATUS_REFERENCE.'_'.$i,$status);

            $manager->persist($status);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProjectFixtures::class,
        ];
    }
}