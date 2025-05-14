<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template-extends ArrayCollection<array-key, Product>
 */
class ProductsCollection extends ArrayCollection
{
    /**
     * @return list<array{id: int, title: string, description: string, price: int, rate: int, measure: string, quantity: int}>
     */
    public function toApi(): array
    {
        /** @var list<Product> $products */
        $products = parent::toArray();
        $data = [];

        foreach($products as $product) {
            $data[] = $product->toArray();
        }

        return $data;
    }
}
