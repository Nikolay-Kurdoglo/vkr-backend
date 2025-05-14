<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Entity\Order;
use App\Collection\OrdersCollection;
use App\Repository\AbstractRepository;
use App\Repository\OrdersRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template TEntity of object
 * @template TCollection of ArrayCollection
 */
class AbstractController
{
    public const string API_PATH = '';
    /**
     * @var class-string<TEntity> string
     */
    protected string $entityClass;
    /**
     * @var AbstractRepository<TEntity, TCollection> $repository
     */
    protected AbstractRepository $repository;
    /**
     * @var non-empty-string $apiPath
     */
    protected string $apiPath;

    public function list(Request $request): Response
    {
        $items = $this->repository->get();

        return new JsonResponse(
            [
                'items' => $items->toApi(),
            ]
        );
    }
}
