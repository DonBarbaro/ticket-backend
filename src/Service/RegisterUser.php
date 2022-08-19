<?php

namespace App\Service;

use App\Dto\InputDto\RegistrationInputDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUser
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    ){}

    public function registerUser(RegistrationInputDto $inputDto): User
    {
        $user = new User();
        $user->setEmail($inputDto->email);
        $plainPassword = $inputDto->password;
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}