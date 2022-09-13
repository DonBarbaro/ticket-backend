<?php

namespace App\Dto\User;


use Symfony\Component\Serializer\Annotation\Groups;

class LoginInput
{
    public string $email;

    public string $password;
}