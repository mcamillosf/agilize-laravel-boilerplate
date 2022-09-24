<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Materia;

class MateriaRepository extends Repository
{
    protected string $entityName = Materia::class;

    /**
     * @param string $name
     * @return float|int|mixed|string
     */
    public function getMateriaByName(string $name): mixed
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

    /**
     * @param $name
     * @return float|int|mixed|string
     */
    public function getMateriaIdByName($name): mixed
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('materia.id')
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
}
