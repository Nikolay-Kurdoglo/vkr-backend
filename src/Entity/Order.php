<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(Order::TABLE_NAME)]
class Order
{
    public const string TABLE_NAME = 'orders';

    #[Id]
    #[GeneratedValue]
    #[Column('id', Types::INTEGER)]
    private int $id;
    #[Column('code', Types::INTEGER)]
    private int $code;
    #[Column('line_items_count', Types::INTEGER)]
    private int $lineItemsCount;
    #[Column('status', Types::INTEGER)]
    private int $status;
    #[Column('date', Types::DATE_MUTABLE)]
    private DateTimeInterface $date;
    #[Column('total_price', Types::FLOAT)]
    private float $totalPrice;
    #[Column('order_picker', Types::STRING)]
    private string $orderPicker;
    #[Column('responsible_support', Types::STRING)]
    private string $responsibleSupport;
    #[Column('customer', Types::STRING)]
    private string $customer;
    #[Column('email', Types::STRING)]
    private string $email;
    #[Column('phone', Types::INTEGER)]
    private int $phone;

    public function setCode(int $code): static 
    {
        $this->code = $code;

        return $this;
    }

    public function setDate(DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function setLineItemsCount(int $lineItemsCount): static 
    {
        $this->lineItemsCount = $lineItemsCount;

        return $this;
    }

    public function setStatus(int $status): static 
    {
        $this->status = $status;

        return $this;
    }

    public function setTotalPrice(float $totalPrice): static 
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function setResponsibleSupport(string $responsibleSupport): static
    {
        $this->responsibleSupport = $responsibleSupport;

        return $this;
    }

    public function setOrderPicker(string $orderPicker): static
    {
        $this->orderPicker = $orderPicker;

        return $this;
    }

    public function setCustomer(string $customer): static 
    {
        $this->customer = $customer;

        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'line_items_count' => $this->lineItemsCount,
            'status' => $this->status,
            'email' => $this->email,
            'total_price' => $this->totalPrice,
            'date' => $this->date->format('Y-m-d'),
            'customer' => $this->customer,
            'phone' => $this->phone,
            'order_picker' => $this->orderPicker,
            'responsible_support' => $this->responsibleSupport,
        ];
    }
}

