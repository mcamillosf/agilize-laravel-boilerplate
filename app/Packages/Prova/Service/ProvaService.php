<?php

namespace App\Packages\Prova\Service;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Domain\Repository\MateriaRepository;
use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use App\Packages\Prova\Domain\Repository\ProvaRepository;
use App\Packages\Prova\Domain\Repository\ProvaSnapshotRepository;
use App\Packages\Prova\Domain\Repository\RespostaRepository;
use App\Packages\User\Domain\Model\User;
use App\Packages\User\Facade\UserFacade;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaService
{
    private ProvaRepository $provaRepository;
    private PerguntaRepository $perguntaRepository;
    private RespostaRepository $respostaRepository;
    private MateriaRepository $materiaRepository;
    private UserFacade $userFacade;
    private Prova $prova;
    private ProvaSnapshotRepository $provaSnapshotRepository;
    CONST MIN = 1;
    CONST MAX = 10;

    public function __construct(
        ProvaRepository $provaRepository,
        PerguntaRepository $perguntaRepository,
        RespostaRepository $respostaRepository,
        MateriaRepository $materiaRepository,
        UserFacade $userFacade,
        Prova $prova,
        ProvaSnapshotRepository $provaSnapshotRepository
    ) {
        $this->provaRepository = $provaRepository;
        $this->perguntaRepository = $perguntaRepository;
        $this->respostaRepository = $respostaRepository;
        $this->materiaRepository = $materiaRepository;
        $this->userFacade = $userFacade;
        $this->prova = $prova;
        $this->provaSnapshotRepository = $provaSnapshotRepository;
    }

    public function createProva($request)
    {
        $materiaId = $this->getMateria($request);
        $user = $this->getAluno($request);
        $qtdPerguntas = $this->getQuantidadePerguntasAleatorias();
        $perguntas = $this->perguntaRepository->getPerguntasAleatorias($qtdPerguntas, $materiaId);
        $status = 'Aberta';
        $prova = $this->provaRepository->createProva($status, $qtdPerguntas, $user, $materiaId, $perguntas);
        $this->provaSnapshotRepository->createProvaSnapshot($prova, $perguntas, $qtdPerguntas);
        return $prova;
    }

    public function getProvaById($provaId)
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
            throw new Exception('Nenhuma prova cadastrada');
        }
        return $provas;
    }

    /**
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function getAluno($request)
    {
        $nome = $request->get('nome');
        $user = $this->userFacade->getUserIdByName($nome);
        if (!$user) {
            throw new Exception('Aluno não cadastrado.');
        }
        $userId = $user['id']->toString();
        /**
         * @var User $user */
        $user = EntityManager::getRepository(User::class)->findOneBy(['id' => $userId]);
        return $user;
    }

    /**
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function getMateria($request)
    {
        $materia = $request->get('materia');
        $materiaBd = $this->materiaRepository->getMateriaIdByName($materia);
        if (!$materiaBd) {
            throw new Exception('Matéria não cadastrada');
        }
        $materiaId = $materiaBd['id']->toString();
        return $materiaId;
    }

    /**
     * @return int
     */
    public function getQuantidadePerguntasAleatorias(): int
    {
        $qtdPerguntas = rand(self::MIN, self::MAX);
        return $qtdPerguntas;
    }
}