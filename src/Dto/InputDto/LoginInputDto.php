<?php

namespace App\Dto\InputDto;


use Symfony\Component\Serializer\Annotation\Groups;

class LoginInputDto
{
    public string $email;

    public string $password;
}