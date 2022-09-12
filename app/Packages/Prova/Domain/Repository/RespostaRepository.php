<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;

class RespostaRepository extends Repository
{
    protected string $entityName = Resposta::class;

    public function getRespostas()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('resposta')
            ->from($this->entityName, 'resposta')
            ->getQuery()
            ->getResult();
    }

    public function getPerguntasByRespostas($idRespostas)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('resposta', 'pergunta')
            ->from($this->entityName, 'resposta')
            ->join('resposta.pergunta', 'pergunta')
            ->where('resposta.id IN (:idRespostas)')
            ->setParameter('idRespostas', $idRespostas)
            ->getQuery()
            ->getResult();
    }
}