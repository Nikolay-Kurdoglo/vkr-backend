<?php

declare(strict_types=1);

namespace App\Constraint\Api\OAuth;

use App\System\Constraint\AbstractConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class AuthenticationDataConstraints extends AbstractConstraint
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'allowMissingFields' => false,
            'allowExtraFields' => false,
            'fields' => [
                'email' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Email(),
                ],
                'password' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(min: 5, max: 24),
                ],
            ],
        ]);
    }
}
