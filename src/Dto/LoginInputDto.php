<?php

namespace App\Dto;


use Symfony\Component\Serializer\Annotation\Groups;

class LoginInputDto
{
    #[Groups(['user:write'])]
    public $userName;

    #[Groups(['user:write'])]
    public $password;
}