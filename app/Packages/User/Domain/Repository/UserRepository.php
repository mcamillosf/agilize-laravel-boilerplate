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

    public function getUserById($id)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('user')
            ->from($this->entityName, 'user')
            ->where('user.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updateUser($id, $nome)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->update($this->entityName, 'user')
            ->set('user.nome', ':nome')
            ->where('user.id = :id')
            ->setParameters([
                'id' => $id,
                'nome' => $nome
            ])
            ->getQuery()
            ->getResult();
    }

    public function createUser($name)
    {
        $user = new User($name);
        $this->add($user);
        return $user;
    }
}