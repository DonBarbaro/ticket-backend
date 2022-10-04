<?php

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Embeddable\NotificationSettings;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationInputDataTransformer implements DataTransformerInterface
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ){}

    public function transform($data, string $to, array $context = [])
    {
        $user = new User();
        $user->setEmail($data->email);
        $plainPassword = $data->password;
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if($data instanceof User){
            return false;
        }

        return User::class === $to && null !== ($context['input']['class'] ?? null);
    }
}