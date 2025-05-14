<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Entity\Order;
use App\Collection\OrdersCollection;
use App\Repository\OrdersRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class OrderController
{
    public function __construct(
        private OrdersRepository $repository
    ) {  
    }

    #[Route(path: '/api/v1/orders', methods: [Request::METHOD_PUT])]
    public function store(Request $request): Response
    {
        $payload = (array) ($request->getPayload()->all()['items'] ?? []);

        $orders = new OrdersCollection();
        foreach ($payload as $order) {
            $orders->add(
                (new Order())
                    ->setCode((int) $order['id'])
                    ->setCustomer($order['customer'])
                    ->setEmail($order['email'])
                    ->setTotalPrice($order['total_price'])
                    ->setStatus((int) $order['status'])
                    ->setResponsibleSupport($order['responsible_support'])
                    ->setOrderPicker($order['order_picker'])
                    ->setPhone((int) preg_replace('/\D+/', '', $order['phone']))
                    ->setDate(DateTime::createFromFormat('Y-d-m', $order['date']))
                    ->setLineItemsCount((int) $order['line_items_count'])
            );
        }

        $orders = $this->repository->add($orders);

        return new JsonResponse(['items' => $orders]);
    }

    #[Route(path: '/api/v1/orders', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $orders = $this->repository->get();

        return new JsonResponse(
            [
                'lines' => $orders->toApi(),
            ]
        );
    }
}
