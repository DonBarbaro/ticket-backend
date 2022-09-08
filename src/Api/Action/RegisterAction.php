<?php

namespace App\Api\Action;

use App\Dto\InputDto\RegistrationInputDto;
use App\Service\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterAction extends AbstractController
{
    public function __construct(
        private RegisterUser $user,
        private ValidatorInterface $validator
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $dto = RegistrationInputDto::fromRequest($request);
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JSONResponse($errorsString, 401);
        }
        $this->user->registerUser($dto);

        return new JsonResponse('New user was created!', 201);
    }

}