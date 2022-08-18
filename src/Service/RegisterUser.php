<?php

namespace App\Service;

use App\Dto\InputDto\RegistrationInputDto;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUser
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function registerUser(RegistrationInputDto $inputDto): User
    {
        $user = new User();
        $user->setEmail($inputDto->email);
        $user->setPlainPassword($inputDto->plainPassword);
        $plainPassword = $user->getPlainPassword();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }

}