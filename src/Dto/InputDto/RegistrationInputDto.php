<?php

namespace App\Dto\InputDto;

use Symfony\Component\HttpFoundation\Request;

class RegistrationInputDto
{
    public string $email;

    public string $password;

//    public string $roles;

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->password = $plainPassword;
        return $this;
    }

    public static function fromRequest(Request $request): self
    {
        $input = $request->toArray();
        return (new self())
            ->setEmail($input['email'] ?? null)
            ->setPlainPassword($input['password'] ?? null);
    }
}