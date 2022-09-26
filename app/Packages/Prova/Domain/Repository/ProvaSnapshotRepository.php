<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\ProvaSnapshot;
use App\Packages\Prova\Domain\Repository\RespostaRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaSnapshotRepository extends Repository
{
    protected string $entityName = ProvaSnapshot::class;
    private RespostaRepository $respEntity;

    /**
     * @param RespostaRepository $respEntity
     */
    public function __construct(RespostaRepository $respEntity)
    {
        $this->respEntity = $respEntity;
    }


    public function getSnapshotById($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('provasnapshot')
            ->from($this->entityName, 'provasnapshot')
            ->where('provasnapshot.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function createProvaSnapshot($prova, $perguntas)
    {
        $perguntasCollection = collect();
        foreach ($perguntas as $pergunta) {
            $respostaCorreta = $this->respEntity->getRespostaCorretaByPerguntaId($pergunta->getId())['resposta'];
            $perguntasCollection->add([
                'pergunta' => $pergunta,
                'resposta' => $respostaCorreta
            ]);
//            dd($prova);
            $snapProva = new ProvaSnapshot($pergunta->getPergunta(), $respostaCorreta, $prova);
            $this->add($snapProva);
        }
    }
}