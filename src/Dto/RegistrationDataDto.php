<?php

declare(strict_types=1);

namespace App\Dto;

readonly class RegistrationDataDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
    ) {
    }
}

