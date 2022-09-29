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
use Carbon\Carbon;
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
    CONST MAX = 2;

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
        $prova = $this->provaRepository->createProva($status, $qtdPerguntas, $user, $materiaId);
        $this->provaSnapshotRepository->createProvaSnapshot($prova, $perguntas);
        $provaCollection = collect();
        $perguntasCollection = collect();
        foreach ($perguntas as $pergunta) {
            $perguntasCollection->add([
                'pergunta' => $pergunta->getPergunta(),
                'alternativas' => $pergunta->getResposta()->toArray()
            ]);
        }
            $provaCollection->add([
                'prova_id' => $prova->getId(),
                'aluno' => $prova->getUser()->getNome(),
                'prova_status' => $prova->getStatus(),
                'materia_prova' => $prova->getMateria()->getMateria(),
                'quantidade_perguntas' => $prova->getQtdPerguntas(),
                'perguntas' => $perguntasCollection->toArray()
            ]);
        $provaAndPerguntas = $provaCollection[0];
        return $provaAndPerguntas;
    }

    public function updateProva($body, $provaId)
    {
        $status = 'Concluída';
        $dataInicioProva = $this->provaRepository->getDataInicioProvaByProvaId($provaId)['inicio'];
        $termino = Carbon::now();
        $diferenca = $termino->diffInMinutes($dataInicioProva);
        if ($diferenca > 60) {
            throw new Exception('Passou dos 60 minutos de prova. Não é possível entregar a prova.');
        }
        $this->provaSnapshotRepository->updateProvaSnapshot($body);
        $nota_prova = $this->getNotaDaProva($provaId);
        $this->provaRepository->updateProva($status, $provaId, $nota_prova);
        EntityManager::flush();
        $prova = $this->provaRepository->getProvaById($provaId);
        return $prova;
    }

    public function getProvaById($provaId)
    {
        $prova =  $this->provaRepository->getProvaById($provaId);

        if (!$prova) {
            throw new Exception('Prova não encontrada');
        }

        $provasCollection = collect();
        $this->getProvaAndProvaSnapshot($prova, $provasCollection);

        return $provasCollection;
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
        $provasCollection = collect();
        foreach ($provas as $prova) {
            $this->getProvaAndProvaSnapshot($prova, $provasCollection);
        }
        return $provasCollection;
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

    public function getNotaDaProva($id)
    {
        $qtd_respostas_certas = count($this->provaSnapshotRepository->getRespostasMarcadasCorretamente($id));
        $qtd_perguntas_prova = $this->provaRepository->getQuantidadeDePerguntasByProvaId($id)['qtdPerguntas'];
        $ponto_por_pergunta = 10 / $qtd_perguntas_prova;
        $nota_prova = $qtd_respostas_certas * $ponto_por_pergunta;

        return $nota_prova;
    }

    /**
     * @param Prova $prova
     * @param \Illuminate\Support\Collection $snapshotCollection
     * @param \Illuminate\Support\Collection $provasCollection
     * @return void
     */
    public function getProvaAndProvaSnapshot(Prova $prova, \Illuminate\Support\Collection $provasCollection): void
    {
        $snapshotCollection = collect();
        $provaId = $prova->getId();
        $provasSnapshot = $this->provaSnapshotRepository->getProvaSnapshotByProvaId($provaId);
        foreach ($provasSnapshot as $provasnapshot) {
            $snapshotCollection->add([
                'pergunta' => $provasnapshot['pergunta'],
                'alternativas' => json_decode($provasnapshot['alternativas']),
            ]);
        }
        $provaItem = [
            'prova_id' => $prova->getId(),
            'aluno' => $prova->getUser()->getNome(),
            'materia' => $prova->getMateria()->getMateria(),
            'status' => $prova->getStatus(),
            'quantidade_perguntas' => $prova->getQtdPerguntas(),
            'perguntas' => $snapshotCollection->toArray(),
        ];
        $provasCollection->add($provaItem);
        $snapshotCollection = collect();

    }
}