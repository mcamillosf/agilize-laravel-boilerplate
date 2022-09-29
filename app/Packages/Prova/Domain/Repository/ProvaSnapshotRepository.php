<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Domain\Model\ProvaSnapshot;
use App\Packages\Prova\Domain\Repository\RespostaRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaSnapshotRepository extends Repository
{
    protected string $entityName = ProvaSnapshot::class;
    private RespostaRepository $respEntity;

    /**
     * @param RespostaRepository $respEntity
     */
    public function __construct(RespostaRepository $respEntity, EntityManagerInterface $em)
    {
        $this->respEntity = $respEntity;
        parent::__construct($em);
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

    public function getProvasSnapshots()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('provasnap')
            ->from($this->entityName, 'provasnap')
            ->getQuery()
            ->getResult();
    }

    public function createProvaSnapshot($prova, $perguntas)
    {
        /** @var RespostaRepository $respEntity */
        foreach ($perguntas as $pergunta) {
            $respostaCorreta = $this->respEntity->getRespostaCorretaByPerguntaId($pergunta->getId())['resposta'];
            $snapProva = new ProvaSnapshot($prova, $pergunta->getPergunta(), $respostaCorreta);
            $this->add($snapProva);
        }
    }

    public function updateProvaSnapshot($body)
    {
        foreach ($body as $item) {
            $this->updateRespostaCorreta($item['pergunta'], $item['resposta']);
        }
    }

    public function updateRespostaCorreta($pergunta, $resposta)
    {
        $fim = Carbon::now('America/Sao_Paulo')->toDate();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->update($this->entityName, 'provasnap')
            ->set('provasnap.resposta_marcada', ':resposta')
            ->set('provasnap.fim', ':fim')
            ->where('provasnap.pergunta = :pergunta')
            ->setParameters([
                'pergunta' => $pergunta,
                'resposta' => $resposta,
                'fim' => $fim
            ])
            ->getQuery()
            ->execute();
    }

    public function getRespostasMarcadasCorretamente($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('provasnap.resposta_marcada')
            ->from($this->entityName, 'provasnap')
            ->join('provasnap.prova', 'prova')
            ->where('provasnap.resposta_correta = provasnap.resposta_marcada')
            ->andWhere('prova.id = :id')
            ->setParameter('id', $id)
            ->groupBy('provasnap.resposta_marcada')
            ->getQuery()
            ->getResult();
    }
}