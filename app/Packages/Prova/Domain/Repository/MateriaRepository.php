<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Materia;

class MateriaRepository extends Repository
{
    protected string $entityName = Materia::class;

    public function getMateriaByName(string $name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia')
            ->from($this->entityName, 'materia')
            ->where('materia.materia = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMateriaById($id)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia')
            ->from($this->entityName, 'materia')
            ->where('materia.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMateriaIdByName($name)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia')
            ->from($this->entityName, 'materia')
            ->where('materia.materia = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMaterias()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia')
            ->from($this->entityName, 'materia')
            ->getQuery()
            ->getResult();
    }

    public function createMateria($materia)
    {
        $mat = new Materia($materia);
        $this->add($mat);
        return $mat;
    }

    public function updateMateria($id, $materia)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->update($this->entityName, 'materia')
            ->set('materia.materia', ':materia')
            ->where('materia.id = :id')
            ->setParameters([
                'id' => $id,
                'materia' => $materia
            ])
            ->getQuery()
            ->getResult();
    }
}
