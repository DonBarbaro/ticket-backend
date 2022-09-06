<?php

namespace App\Dto\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationInput
{

    public string $email;

    #[Assert\Length(
        min: 6,
        minMessage: 'Password must be at least 6 long'
    )]
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