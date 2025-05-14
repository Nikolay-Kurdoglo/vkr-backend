<?php

declare(strict_types=1);

namespace App\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;

/**
 * @template-extends ArrayCollection<array-key, User>
 */
class UsersCollection extends ArrayCollection
{
    public function toApi()
    {
        /** @var list<User> $users */
        $users = parent::toArray();
        $data = [];

        foreach($users as $user) {
            $data[] = $user->toArray();
        }

        return $data;
    }
}
