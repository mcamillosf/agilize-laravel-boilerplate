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
            ->where('user.nome = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUserIdByName($name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('user.id')
            ->from($this->entityName, 'user')
            ->where('user.nome = :nome')
            ->setParameter('nome', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAllUsers()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('user')
            ->from($this->entityName, 'user')
            ->getQuery()
            ->getResult();
    }

    public function createUser($name)
    {
        $user = new User($name);
        $this->add($user);
        return 'Usuário criado com sucesso';
    }
}