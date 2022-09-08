<?php

namespace App\Dto\InputDto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationInputDto
{
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    public string $email;

    #[Assert\Length(
        min: 6,
        minMessage: 'Your password must be at least 6 characters long',
    )]
    public string $password;

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