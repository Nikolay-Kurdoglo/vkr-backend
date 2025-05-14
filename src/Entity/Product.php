<?php

declare(strict_types=1);

namespace App\Entity;

use App\Collection\ProductsCollection;
use App\Enum\Measurement;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use InvalidArgumentException;

#[Entity]
#[Table(Product::TABLE_NAME)]
class Product implements EntityInterface
{
    public const string TABLE_NAME = 'products';

    #[Id]
    #[GeneratedValue]
    #[Column('id', Types::INTEGER)]
    private int $id;
    #[Column('title', Types::STRING)]
    private string $title;
    #[Column('description', Types::STRING)]
    private string $description;
    #[Column('quantity', Types::INTEGER)]
    private int $quantity;
    #[Column('measure', Types::INTEGER, enumType: Measurement::class)]
    private Measurement $measure;
    #[Column('price', Types::FLOAT)]
    private float $price;
    #[Column('rate', Types::FLOAT)]
    private float $rate;
    #[Column('weight', Types::FLOAT)]
    private float $weight;
    #[Column('category', Types::STRING)]
    private string $category;
    #[Column('warehouse_address', Types::STRING)]
    private string $warehouseAddress;
    #[Column('sku', Types::INTEGER)]
    private int $sku;

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setMeasurement(Measurement $measure): static
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * @return array{
     *      id: int,
     *      title: string,
     *      description: string,
     *      price: float,
     *      rate: float,
     *      measure: string,
     *      quantity: int,
     *      sku: int,
     *      category: string,
     *      warehouse_address: string,
     *      weight: float
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'measure' => $this->measure->toCode(),
            'rate' => $this->rate,
            'price' => $this->price,
            'weight' => $this->weight,
            'warehouse_address' => $this->warehouseAddress,
            'category' => $this->category,
            'sku' => $this->sku,
        ];
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param int $rate
     * @return static
     * @throws InvalidArgumentException
     */
    public function setRate(float $rate): static
    {
        if ($rate < 1 || $rate > 5) {
            throw new InvalidArgumentException('Rate cannot be more of 5 and less than 1');
        }

        $this->rate = $rate;

        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getWarehouseAddress(): string
    {
        return $this->warehouseAddress;
    }

    public function setWarehouseAddress(string $warehouseAddress): static
    {
        $this->warehouseAddress = $warehouseAddress;

        return $this;
    }

    public function getSku(): int
    {
        return $this->sku;
    }

    public function setSku(int $sku): static
    {
        $this->sku = $sku;

        return $this;
    }
}
