<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\ProductsCollection;
use App\Entity\Product;

/**
 * @template-extends AbstractRepository<Product, ProductsCollection>
 */
class ProductRepository extends AbstractRepository
{
    protected string $alias = 'p';
    protected string $className = Product::class;
    protected string $collectionType = ProductsCollection::class;

    public function getCount(): int
    {
        $result = $this
            ->createQueryBuilder('p')
            ->select(['count(p.id)'])
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $result;
    }
}

