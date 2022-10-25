<?php

namespace App\Api\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationInput
{

    public string $email;

    #[Assert\Length(
        min: 6,
        minMessage: 'Password must be at least 6 long'
    )]
    public string $password;
}