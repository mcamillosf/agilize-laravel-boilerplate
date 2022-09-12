<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Pergunta;

class PerguntaRepository extends Repository
{
    protected string $entityName = Pergunta::class;

    public function getPerguntas()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->getQuery()
            ->getResult();
    }
}