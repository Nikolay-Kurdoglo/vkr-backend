<?php

declare(strict_types=1);

namespace App\Constraint\Api\OAuth;

use App\System\Constraint\AbstractConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDataConstraints extends AbstractConstraint
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
                'first_name' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                ],
                'last_name' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                ],
                'password' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(min: 5, max: 24),
                ],
                'password_confirmation' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length(min: 5, max: 24),
                ],
            ],
        ]);
    }
}
