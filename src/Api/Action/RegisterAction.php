<?php

namespace App\Api\Action;

use App\Dto\InputDto\RegistrationInputDto;
use App\Service\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegisterAction extends AbstractController
{
    public function __construct(
        private RegisterUser $user
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $dto = RegistrationInputDto::fromRequest($request);
        $registered = $this->user->registerUser($dto);

        return new JsonResponse('New user was created!', 201);
    }

}