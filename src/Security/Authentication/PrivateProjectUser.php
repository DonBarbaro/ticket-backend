<?php

namespace App\Security\Authentication;

use App\Entity\Project;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
class PrivateProjectUser implements UserInterface
{

    public function __construct(private string $token, private Project $project)
    {

    }

    public function getRoles(): array
    {
       return [];
    }

    public function getPassword()
    {
        return $this->token;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->token;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): PrivateProjectUser
    {
        $this->project = $project;
        return $this;
    }
}