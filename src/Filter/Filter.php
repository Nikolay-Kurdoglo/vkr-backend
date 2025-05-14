<?php

declare(strict_types=1);

namespace App\Filter;

readonly class Filter
{
    public function __construct(
        public int $page,
        public int $perPage,
        public ?string $column = null,
    ) {
    }

    public function getOffset(): int
    {
        return $this->page > 1 
            ? ($this->page - 1) * $this->perPage 
            : 0;
    }

    public function getLimit(): int
    {
        return $this->perPage;
    }
}

