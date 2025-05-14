<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Collection\OrdersCollection;

/**
 * @template-extends AbstractRepository<Order, OrdersCollection>
 */
class OrdersRepository extends AbstractRepository
{
    protected string $alias = 'o';
    protected string $className = Order::class;
    protected string $collectionType = OrdersCollection::class;
}
