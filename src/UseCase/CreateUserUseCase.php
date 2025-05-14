<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Task\CreateUserTask;
use DateTime;
use Lcobucci\JWT\JwtFacade;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class CreateUserUseCase
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }
    public function handle(CreateUserTask $task): void
    {
        $key = InMemory::base64Encoded((string) getenv('SECRET_KEY'));

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            static fn (
                Builder $builder,
                DateTimeImmutable $issuedAt
            ): Builder => $builder
                ->issuedBy('https://api.my-awesome-app.io')
                ->permittedFor('https://client-app.io')
                ->expiresAt($issuedAt->modify('+24 hours'))
                ->withClaim('first_name', $task->registrationDataDto->firstName)
                ->withClaim('last_name', $task->registrationDataDto->lastName)
                ->withClaim('email', $task->registrationDataDto->email)
        );

        $user = (new User())
            ->setFirstName($task->registrationDataDto->firstName)
            ->setLastName($task->registrationDataDto->lastName)
            ->setEmail($task->registrationDataDto->email)
            ->setToken($token->toString())
            ->setPassword($task->registrationDataDto->password)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());

        $this->repository->addOne($user);

        $task->setSuccess(true);
    }
}

