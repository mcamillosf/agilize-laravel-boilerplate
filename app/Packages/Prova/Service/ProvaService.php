<?php

namespace App\Packages\Prova\Service;


use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Domain\Repository\MateriaRepository;
use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use App\Packages\Prova\Domain\Repository\ProvaRepository;
use App\Packages\Prova\Domain\Repository\RespostaRepository;
use App\Packages\User\Facade\UserFacade;
use Doctrine\Common\Collections\ArrayCollection;

class ProvaService
{
    private ProvaRepository $provaRepository;
    private PerguntaRepository $perguntaRepository;
    private RespostaRepository $respostaRepository;
    private MateriaRepository $materiaRepository;
    private UserFacade $userFacade;
    private Prova $prova;

    public function __construct(
        ProvaRepository $provaRepository,
        PerguntaRepository $perguntaRepository,
        RespostaRepository $respostaRepository,
        MateriaRepository $materiaRepository,
        UserFacade $userFacade,
        Prova $prova
    ) {
        $this->provaRepository = $provaRepository;
        $this->perguntaRepository = $perguntaRepository;
        $this->respostaRepository = $respostaRepository;
        $this->materiaRepository = $materiaRepository;
        $this->userFacade = $userFacade;
        $this->prova = $prova;
    }

    public function createProva($request)
    {
        $nome = $request->get('nome');
        $materia = $request->get('materia');
        $materiaId = $this->materiaRepository->getMateriaIdByName($materia)['id']->toString();
        $userId = $this->userFacade->getUserIdByName($nome)['id']->toString();
        $qtdPerguntas = rand($min = 1, $max = 10);
        $perguntas = $this->perguntaRepository->getPerguntasAleatorias($qtdPerguntas, $materiaId);
        /** @var Pergunta $pergunta */
        $perguntasCollection = new ArrayCollection();
        foreach ($perguntas as $pergunta) {
            $perguntasCollection->add([
               'pergunta' => $pergunta->getPergunta(),
               'respostas' => $pergunta->getResposta()->toArray()
            ]);
        }
        $status = 'Aberta';
        $prova = $this->provaRepository->createProva($status, $qtdPerguntas, $userId, $materiaId, $perguntas);

        return $prova;
    }

    /**
     * @param $provaId
     * @return float|int|mixed|string
     */
    public function getProvaById($provaId): mixed
    {
        return $this->provaRepository->getProvaById($provaId);
    }

    public function getProvasByUser($userId)
    {
        return $this->provaRepository->getProvasByUserName($userId);
    }

    public function getProvas()
    {
        $provas = $this->provaRepository->getProvas();
        if (!$provas) {
            throw new \Exception('Nenhuma prova cadastrada');
        }
        return $provas;
    }
}