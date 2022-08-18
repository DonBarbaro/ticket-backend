<?php

namespace App\Api\Action;

use App\Dto\InputDto\RegistrationInputDto;
use App\Entity\User;
use App\Service\RegisterUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegisterAction extends AbstractController
{
    private $entityManager;
    private RegisterUser $user;

    public function __construct(EntityManagerInterface $entityManager, RegisterUser $user)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    public function __invoke(Request $request): User
    {
        $dto = RegistrationInputDto::fromRequest($request);
        $registered = $this->user->registerUser($dto);

//        dd($registered);

        $this->entityManager->persist($registered);
        $this->entityManager->flush();

        return $registered;
    }

}