<?php

namespace App\Packages\Prova\Facade;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Domain\Model\Resposta;
use App\Packages\Prova\Service\MateriaService;
use App\Packages\Prova\Service\PerguntaService;
use App\Packages\Prova\Service\ProvaService;
use App\Packages\Prova\Service\RespostaService;
use Doctrine\ORM\NonUniqueResultException;

class ProvaFacade
{
    private ProvaService $provaService;
    private PerguntaService $perguntaService;
    private RespostaService $respostaService;
    private MateriaService $materiaService;

    public function __construct(ProvaService $provaService, PerguntaService $perguntaService, RespostaService $respostaService, MateriaService $materiaService)
    {
        $this->provaService = $provaService;
        $this->perguntaService = $perguntaService;
        $this->respostaService = $respostaService;
        $this->materiaService = $materiaService;
    }

    public function createPergunta($request)
    {
        return $this->perguntaService->createPergunta($request);
    }

    public function getPerguntas()
    {
        return $this->perguntaService->getPerguntas();
    }

    /**
     * @param $perguntaId
     * @return float|int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getPerguntaById($perguntaId): mixed
    {
        return $this->perguntaService->getPerguntaById($perguntaId);
    }


    public function createResposta($request)
    {
        return $this->respostaService->createResposta($request);
    }

    /**
     * @return mixed
     */
    public function getRespostas(): mixed
    {
        return $this->respostaService->getRespostas();
    }

    /**
     * @param $respostaId
     * @return mixed
     */
    public function getRespostaById($respostaId): mixed
    {
        return $this->respostaService->getRespostaById($respostaId);
    }

    public function createMateria($request)
    {
        return $this->materiaService->createMateria($request);
    }

    public function getMaterias()
    {
        return $this->materiaService->getMaterias();
    }

    /**
     * @param $materia
     * @return float|int|mixed|string
     */
    public function getMateriaByName($materia): mixed
    {
        return $this->materiaService->getMateriaByName($materia);
    }

    public function createProva($request)
    {
        return $this->provaService->createProva($request);
    }

    public function getProvas()
    {
        return $this->provaService->getProvas();
    }

    /**
     * @param $provaId
     * @return mixed
     */
    public function getProvaById($provaId): mixed
    {
        return $this->provaService->getProvaById($provaId);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getProvasByUser($userId): mixed
    {
        return $this->provaService->getProvasByUser($userId);
    }
}