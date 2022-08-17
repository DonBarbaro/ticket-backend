<?php

namespace App\Dto;


use Symfony\Component\Serializer\Annotation\Groups;

class LoginInputDto
{
    public string $email;

    public string $password;
}