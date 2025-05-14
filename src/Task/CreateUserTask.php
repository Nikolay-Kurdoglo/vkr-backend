<?php

declare(strict_types=1);

namespace App\Task;

use App\Dto\RegistrationDataDto;

class CreateUserTask
{
    private bool $isSuccess;

    public function __construct(
        public RegistrationDataDto $registrationDataDto,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function setSuccess(bool $isSuccess): void
    {
        $this->isSuccess = $isSuccess;
    }
}

