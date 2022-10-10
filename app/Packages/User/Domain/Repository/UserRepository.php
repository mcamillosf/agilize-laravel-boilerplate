<?php

namespace App\Packages\User\Domain\Repository;

use App\Packages\Base\Repository;
use App\Packages\User\Domain\Model\User;

class UserRepository extends Repository
{
    protected string $entityName = User::class;

    public function findUserByName(string $name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('user')
            ->from($this->entityName, 'user')
            ->where('user.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}