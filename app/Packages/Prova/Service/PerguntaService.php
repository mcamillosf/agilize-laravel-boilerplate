<?php

namespace App\Packages\Prova\Service;


use App\Packages\Prova\Domain\Repository\MateriaRepository;
use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use Doctrine\ORM\NonUniqueResultException;

class PerguntaService
{
    private PerguntaRepository $perguntaRepository;
    private MateriaRepository $materiaRepository;

    /**
     * @param PerguntaRepository $perguntaRepository
     */
    public function __construct(PerguntaRepository $perguntaRepository, MateriaRepository $materiaRepository)
    {
        $this->materiaRepository = $materiaRepository;
        $this->perguntaRepository = $perguntaRepository;
    }

    public function createPergunta($pergunta, $materia)
    {
        $perg = $this->perguntaRepository->getPerguntaByPergunta($pergunta);
        if ($perg) {
            throw new \Exception('Pergunta ja cadastrada no banco de dados!');
        }
        $materiaId = $this->materiaRepository->getMateriaIdByName($materia);
        if (!$materiaId) {
            throw new \Exception('Matéria não existe no banco de dados');
        }
        $perguntacriada = $this->perguntaRepository->createPergunta($pergunta, $materiaId);

        return $perguntacriada;
    }

    /**
     * @param $perguntaId
     * @return float|int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getPerguntaById($perguntaId): mixed
    {
        return $this->perguntaRepository->getPerguntaById($perguntaId);
    }

    public function getPerguntas()
    {
        return $this->perguntaRepository->getPerguntas();
    }

    public function updatePergunta($id, $request)
    {
        $pergunta = $request['pergunta'];
        $this->perguntaRepository->updatePergunta($id, $pergunta);
        return $this->getPerguntaById($id);
    }
}