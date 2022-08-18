<?php

namespace App\Dto\InputDto;

use Symfony\Component\HttpFoundation\Request;

class RegistrationInputDto
{
    public string $email;

    public string $plainPassword;

//    public string $roles;

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

//    /**
//     * @param string $roles
//     */
//    public function setRoles(string $roles): self
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    public static function fromRequest(Request $request): self
    {
        $input = $request->toArray();
        return (new self())
            ->setEmail($input['email'] ?? null)
            ->setPlainPassword($input['plainPassword'] ?? null);
//            ->setRoles($input['roles'] ?? null);
    }
}