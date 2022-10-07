<?php

namespace App\Packages\Prova\Facade;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Domain\Model\ProvaSnapshot;
use App\Packages\Prova\Domain\Model\Resposta;
use App\Packages\Prova\Domain\Repository\ProvaSnapshotRepository;
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

    public function getPerguntaById($perguntaId)
    {
        return $this->perguntaService->getPerguntaById($perguntaId);
    }

    public function updatePergunta($id, $request)
    {
        return $this->perguntaService->updatePergunta($id, $request);
    }

    public function createResposta($request)
    {
        return $this->respostaService->createResposta($request);
    }

    public function getRespostas()
    {
        return $this->respostaService->getRespostas();
    }

    public function getRespostaById($respostaId)
    {
        return $this->respostaService->getRespostaById($respostaId);
    }

    public function updateResposta($id, $request)
    {
        return $this->respostaService->updateRespostaById($id, $request);
    }

    public function createMateria($nomeMateria)
    {
        return $this->materiaService->createMateria($nomeMateria);
    }

    public function getMaterias()
    {
        return $this->materiaService->getMaterias();
    }

    public function getMateriaByName($materia)
    {
        return $this->materiaService->getMateriaByName($materia);
    }

    public function getMateriaById($materiaId)
    {
        return $this->materiaService->getMateriaById($materiaId);
    }

    public function updateMateria($id, $request)
    {
        return $this->materiaService->updateMateria($id, $request);
    }

    public function createProva($request)
    {
        return $this->provaService->createProva($request);
    }

    public function finalizarProva($body, $id)
    {
        return $this->provaService->updateProva($body, $id);
    }

    public function getProvas()
    {
        return $this->provaService->getProvas();
    }

    public function getProvaById($provaId)
    {
        return $this->provaService->getProvaById($provaId);
    }

    public function getProvasByUser($userId)
    {
        return $this->provaService->getProvasByUser($userId);
    }
}