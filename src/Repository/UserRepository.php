<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\UsersCollection;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<User, UsersCollection>
 */
class UserRepository extends AbstractRepository
{
    protected string $alias = 'u';
    protected string $className = User::class;
    protected string $collectionType = UsersCollection::class;

    public function findOneByEmail(string $email): ?User
    {
        return $this
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

