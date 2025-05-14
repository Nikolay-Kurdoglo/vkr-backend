<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template-extends ArrayCollection<array-key, Order>
 */
class OrdersCollection extends ArrayCollection
{
    public function toApi(): array
    {
        /** @var list<Order> $orders */
        $orders = parent::toArray();
        $data = [];

        foreach($orders as $order) {
            $data[] = $order->toArray();
        }

        return $data;
    }
}
