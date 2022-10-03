<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const  PROJECT_REFERENCE = 'project';
    public const PROJECT_COUNT = 2;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < self::PROJECT_COUNT; $i++) {
            $project = new Project();
            $project->setName('NewProjekt_'.$i);
            for($j = (2*$i); $j < (UsersFixtures::USER_COUNT - 2 + 2*$i); $j++) {
                /**
                 * @var User $user
                 */
                $user = $this->getReference(UsersFixtures::USER_REFERENCE.'_'.$j);
                $project->addUsers($user);
            }
            $manager->persist($project);

            $this->addReference(self::PROJECT_REFERENCE.'_'.$i, $project);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}