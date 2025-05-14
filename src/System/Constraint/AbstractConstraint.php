<?php

declare(strict_types=1);

namespace App\System\Constraint;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

abstract class AbstractConstraint
{
    abstract public function getConstraints(): Assert\Collection;

    /**
     * @param array<mixed> $data
     * @return list<array{code: string, message: string, parameters: array<mixed>}>
     */
    public function validate(array $data): array
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($data, $this->getConstraints());

        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'code' => $violation->getCode(),
                'message' => $violation->getMessage(),
                'parameters' => $violation->getParameters(),
            ];
        }

        return $errors;
    }
}
