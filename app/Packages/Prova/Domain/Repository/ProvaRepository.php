<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Prova;

class ProvaRepository extends Repository
{
    protected string $entityName = Prova::class;

    public function getProvaById($id)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('prova')
            ->from($this->entityName, 'prova')
            ->where('prova.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function getProvasByUserName($name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('prova', 'user')
            ->from($this->entityName, 'prova')
            ->join('prova.user', 'user')
            ->where('user.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function getProvasByMateria($materia)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('prova', 'materia')
            ->from($this->entityName, 'prova')
            ->join('prova.materia', 'materia')
            ->where('materia.name = :name')
            ->setParameter('name', $materia)
            ->getQuery()
            ->getResult();
    }

}