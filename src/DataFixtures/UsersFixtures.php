<?php

namespace App\DataFixtures;

use App\Entity\Embeddable\NotificationSettings;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{

    public const USER_REFERENCE = 'admin';
    public const USER_COUNT = 4;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ){}

    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < self::USER_COUNT; $i++){
            $user  = new User();
            $user->setEmail('admin'.$i.'@mailinator.com');
            $plainPassword = 'password'.$i;
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plainPassword
            );

            $user->setPassword($hashedPassword);
            if ($i == 0){
                $user->setRoles(['ROLE_ADMIN']);
            }else {
                $user->setRoles(['ROLE_USER']);
            }

            $notificationSettings = new NotificationSettings();
            $notificationSettings->setTelegramId("5336884988");
            $notificationSettings->setEmailId("not null");
            $user->setNotificationSettings($notificationSettings);

            $this->addReference(self::USER_REFERENCE.'_'.$i , $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
