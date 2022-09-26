<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Resposta;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\ResultSetMapping;
use LaravelDoctrine\ORM\Facades\EntityManager;

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

    public function getRespostaCorretaByPerguntaId($id, $correta = true)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('resposta.resposta')
            ->from($this->entityName, 'resposta')
            ->join('resposta.pergunta', 'pergunta')
            ->where('resposta.respostaCorreta = :correta')
            ->andWhere('pergunta.id = :id')
            ->setParameter('id', $id)
            ->setParameter('correta', $correta)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $respostaId
     * @return float|int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getRespostaById($respostaId): mixed
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('resposta')
            ->from($this->entityName, 'resposta')
            ->where('resposta.id = :respostaId')
            ->setParameter('respostaId', $respostaId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getRespostaIdByResposta($resposta)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('resposta.id')
            ->from($this->entityName, 'resposta')
            ->where('resposta.resposta = :resposta')
            ->setParameter('resposta', $resposta)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $idRespostas
     * @return float|int|mixed|string
     */
    public function getPerguntasByRespostas($idRespostas): mixed
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

    /**
     * @param $perguntaId
     * @param $resposta
     * @param $respostaCorreta
     * @return Resposta
     */
    public function createResposta($perguntaId, $resposta, $respostaCorreta): Resposta
    {
        /**
         * @var Pergunta $pergunta */
        $pergunta = EntityManager::getRepository(Pergunta::class)->findOneBy(['id' => $perguntaId]);
        $res = new Resposta($resposta, $respostaCorreta, $pergunta);
        $pergunta->addResposta($res);
        $this->add($res);
        $this->update($pergunta);
        return $res;
    }
}