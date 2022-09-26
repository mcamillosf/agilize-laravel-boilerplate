<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\User\Domain\Model\User;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaRepository extends Repository
{
    protected string $entityName = Prova::class;

    /**
     * @param $id
     * @return float|int|mixed|string
     */
    public function getProvaById($id): mixed
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

    /**
     * @param $materia
     * @return float|int|mixed|string
     */
    public function getProvasByMateria($materia): mixed
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

    /**
     * @param $name
     * @return float|int|mixed|string
     */
    public function getProvaAndMateriaByUserName($name): mixed
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('prova', 'materia', 'user')
            ->from($this->entityName, 'prova')
            ->join('prova.materia', 'materia')
            ->join('prova.user', 'user')
            ->where('user.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function getProvas()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('prova')
            ->from($this->entityName, 'prova')
            ->getQuery()
            ->getResult();
    }

    public function createProva($status, $qtdPerguntas, $userId, $materiaId, $perguntas)
    {
        /**
         * @var User $user */
        $user = EntityManager::getRepository(User::class)->findOneBy(['id' => $userId]);
        /**
         * @var Materia $materia */
        $materia = EntityManager::getRepository(Materia::class)->findOneBy(['id' => $materiaId]);
        $inicio = Carbon::now();
        $prova = new Prova($status, $qtdPerguntas, $user, $materia, $inicio);
        $this->add($prova);
        $prova->addPerguntas($perguntas);
        return $prova;
    }

}