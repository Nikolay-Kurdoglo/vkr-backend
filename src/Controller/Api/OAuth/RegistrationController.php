<?php

declare(strict_types=1);

namespace App\Controller\Api\OAuth;

use App\Entity\User;
use App\Task\CreateUserTask;
use Doctrine\ORM\EntityManager;
use App\Dto\RegistrationDataDto;
use App\UseCase\CreateUserUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Constraint\Api\OAuth\UserRegistrationDataConstraints;

#[AsController]
class RegistrationController
{
    public function __construct(
        private UserRegistrationDataConstraints $validator,
        private CreateUserUseCase $useCase,
    ) {
    }

    #[Route(path: '/api/oauth', methods: [Request::METHOD_POST])]
    public function store(Request $request): Response
    {
        /**
         * @var array{
         *      password: string,
         *      password_confirmation: string,
         *      email: string,
         *      first_name: string,
         *      last_name: string
         * } $data
         */
        $data = $request->getPayload()->all();
        $validationErrors = $this->validator->validate($data);

        if (count($validationErrors) > 0) {
            return new JsonResponse(
                [
                    'error' => 'Validation error',
                    'details' => $validationErrors,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->useCase->handle(
            $task = new CreateUserTask(
                new RegistrationDataDto(
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $data['password']
                )
            )
        );

        if (!$task->isSuccess()) {
            return new JsonResponse(['error' => 'failed to create user'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'ok']);
    }
}

