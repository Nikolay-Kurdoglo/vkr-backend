<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Collection\ProductsCollection;
use App\Constraint\Api\V1\ProductsListConstraint;
use App\Entity\Product;
use App\Enum\Measurement;
use App\Filter\Filter;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class ProductController
{
    private const string PATH = 'api/v1/products';

    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    #[Route(path: self::PATH, methods: [Request::METHOD_PUT])]
    public function add(Request $request): Response
    {
        $payload = $request->getPayload();

        /** @var list<array{title: string, description: string, price: float, quantity: int, measure: int, rate: float, category: string, sku: int, weight: float, warehouse_address: string}> $productsData */
        $productsData = (array) $payload->all()['items'] ?? [];

        $products = new ProductsCollection();
        foreach ($productsData as $productData) {
            $products->add(
                (new Product())
                    ->setTitle($productData['title'])
                    ->setDescription($productData['description'])
                    ->setPrice($productData['price'])
                    ->setRate($productData['rate'])
                    ->setWeight($productData['weight'])
                    ->setMeasurement(Measurement::tryFrom($productData['measure']))
                    ->setQuantity($productData['quantity'])
                    ->setWarehouseAddress($productData['warehouse_address'])
                    ->setCategory($productData['category'])
                    ->setSku($productData['sku'])
            );
        }

        $products = $this->productRepository->add($products);

        return new JsonResponse(['data' => $products->toArray()]);
    }

    #[Route(path: self::PATH, methods: [Request::METHOD_GET])]
    public function list(Request $request, ProductsListConstraint $validator): Response
    {
        $query = $request->query->all();
        if (($errors = $validator->validate($query)) > 0) {
            new JsonResponse(['error' => 'validation error', 'violations' => $errors]);
        }

        $filter = null;
        if (!empty($query['page']) || !empty($query['per_page'])) {
            $filter = new Filter(
                (int) ($query['page'] ?? 0),
                (int) $query['per_page'] ?: 24,
                'sku'
            );
        }

        $products = $this->productRepository->get($filter);

        return new JsonResponse(['items' => $products->toApi()]);
    }


    #[Route(path: self::PATH . '/pagination', methods: [Request::METHOD_GET])]
    public function paginationInfo(): Response
    {
        $count = $this->productRepository->getCount();
        $responseData = [
            'data' => [
                'total' => $count,
            ],
        ];

        if ($count > ProductRepository::DEFAULT_LIMIT) {
            $pagesCount = ceil($count / ProductRepository::DEFAULT_LIMIT);

            for ($i = 0; $i < $pagesCount; $i++) {
                $responseData['data']['pages'][] = [
                    'page' => sprintf('/api/v1/products?page=%d&per_page=%d', ($i + 1), ProductRepository::DEFAULT_LIMIT),
                ];
            }
        }

        return new JsonResponse($responseData);
    }

    #[Route(path: self::PATH, methods: [Request::METHOD_POST])]
    public function editOrCreate(Request $request): Response
    {
        $payload = (array) $request->getPayload()->all();

        $productData = $payload['product'];
        $action = $payload['action'];

        $product = $action === 'edit'
            ? $this->productRepository->findOneById(abs((int) $productData['id']))
            : new Product();

        $product = $product
            ->setTitle($productData['title'])
            ->setDescription($productData['description'])
            ->setPrice((float) $productData['price'])
            ->setRate((float) $productData['rate'])
            ->setWeight((float) $productData['weight'])
            ->setMeasurement(Measurement::fromCode((string) $productData['measure']))
            ->setQuantity((int) $productData['quantity'])
            ->setWarehouseAddress($productData['warehouse_address'])
            ->setCategory($productData['category'])
            ->setSku((int) $productData['sku']);

        $product = $this->productRepository->editOne($product);

        return new JsonResponse(['status' => 'ok', 'product' => $product]);
    }
}
