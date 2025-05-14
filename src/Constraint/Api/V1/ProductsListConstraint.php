<?php

declare(strict_types=1);

namespace App\Constraint\Api\V1;

use App\System\Constraint\AbstractConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class ProductsListConstraint extends AbstractConstraint
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'allowExtraFields' => true,
            'allowMissingFields' => true,
            'fields' => [
                'page' => new Assert\Optional([
                    new Assert\NotBlank(),
                    new Assert\Type('numeric'),
                    new Assert\Range(['min' => 1, 'max' => 100]),
                ]),
                'per_page' => new Assert\Optional([
                    new Assert\NotBlank(),
                    new Assert\Type('numeric'),
                    new Assert\Range(['min' => 1, 'max' => 100]),
                ]),
            ],
        ]);
    }
}

