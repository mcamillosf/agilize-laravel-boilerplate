<?php

namespace App\Packages\Prova\Domain\Repository;


use App\Packages\Base\Repository;
use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Pergunta;
use Doctrine\ORM\NonUniqueResultException;
use LaravelDoctrine\ORM\Facades\EntityManager;

class PerguntaRepository extends Repository
{
    protected string $entityName = Pergunta::class;

    public function getPerguntasAleatorias($limite, $materia)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->where('pergunta.materia = :materia')
            ->setParameter('materia', $materia)
            ->orderBy('RANDOM()')
            ->setMaxResults($limite)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $perguntaId
     * @return float|int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getPerguntaById($perguntaId): mixed
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->where('pergunta.id = :perguntaId')
            ->setParameter('perguntaId', $perguntaId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPerguntaIdByPergunta($pergunta)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta.id')
            ->from($this->entityName, 'pergunta')
            ->where('pergunta.pergunta = :pergunta')
            ->setParameter('pergunta', $pergunta)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $pergunta
     * @throws NonUniqueResultException
     */
    public function getPerguntaByPergunta($pergunta)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->where('pergunta.pergunta = :pergunta')
            ->setParameter('pergunta', $pergunta)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPerguntas()
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('pergunta')
            ->from($this->entityName, 'pergunta')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $pergunta
     * @param $materiaId
     * @return Pergunta
     */
    public function createPergunta($pergunta, $materiaId): Pergunta
    {
        /**
         * @var Materia $materia */
        $materia = EntityManager::getRepository(Materia::class)->findOneBy(['id' => $materiaId]);
        $perg = new Pergunta($pergunta, $materia);
        $this->add($perg);
        return $perg;
    }

    public function updatePergunta($id, $pergunta)
    {
        $queryBuilder = $this->GetEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->update($this->entityName, 'pergunta')
            ->set('pergunta.pergunta', ':pergunta')
            ->where('pergunta.id = :id')
            ->setParameters([
                'id' => $id,
                'pergunta' => $pergunta
            ])
            ->getQuery()
            ->getResult();
    }
}