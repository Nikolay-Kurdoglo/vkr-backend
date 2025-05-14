<?php

declare(strict_types=1);

namespace App\Controller\Api\OAuth;

use App\Constraint\Api\OAuth\AuthenticationDataConstraints;
use App\Exception\InvalidAuthorizationToken;
use App\Helper\JwtHelper;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class AuthenticateController
{
    public function __construct(
        private AuthenticationDataConstraints $validator,
        private UserRepository $repository,
    ) {
    }

    #[Route(path: '/api/oauth/authenticate', methods: [Request::METHOD_POST])]
    public function index(Request $request): Response
    {
        /** @var array{email: string, password: string} $data */
        $data = $request->getPayload()->all();

        $validationErrors = $this->validator->validate($data);

        if (!empty($validationErrors)) {
            return new JsonResponse(
                [
                    'error' => 'Validation errors',
                    'details' => $validationErrors
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        [$type, $token] = explode(' ', $request->headers->get('Authorization'));

        try {
            JwtHelper::isValid($token);
        } catch(InvalidAuthorizationToken) {
            return new JsonResponse(
                [
                    'error' => 'Authorization error',
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return new JsonResponse(['status' => 'ok']);
    }
}

