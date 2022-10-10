<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;

class MateriaRepository extends Repository
{
    protected string $entityName = Materia::class;

    public function findMateriaByName(string $name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia')
            ->from($this->entityName, 'materia')
            ->where('materia.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}
