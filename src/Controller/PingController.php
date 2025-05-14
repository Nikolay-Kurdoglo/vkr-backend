<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingController
{
    #[Route('/ping')]
    public function index(): Response
    {
        return new JsonResponse(['ping' => 'pong']);
    }
}
