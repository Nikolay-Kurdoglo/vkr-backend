<?php

declare(strict_types=1);

namespace App\ValueObject;

class ProductParameters
{
    /**
     * @param array<string, string>
     */
    public function __construct(
        private array $parameters
    ) {
    }

    public function getProperty(string $property): ?string
    {
        return (string) ($this->parameters[$property] ?? null) ?: null;
    }
}
