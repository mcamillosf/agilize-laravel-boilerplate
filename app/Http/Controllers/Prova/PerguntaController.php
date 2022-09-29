<?php

namespace App\Http\Controllers\Prova;


use App\Http\Controllers\Controller;
use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Resposta;
use App\Packages\Prova\Facade\ProvaFacade;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class PerguntaController extends Controller
{
    private ProvaFacade $provaFacade;

    /**
     * @param ProvaFacade $provaFacade
     */
    public function __construct(ProvaFacade $provaFacade)
    {
        $this->provaFacade = $provaFacade;
    }

    public function index()
    {
        $perguntas = $this->provaFacade->getPerguntas();
        $perguntasCollection = collect();
        /** @var Pergunta $pergunta */
        foreach ($perguntas as $pergunta) {
            $perguntasCollection->add([
               'pergunta_id' => $pergunta->getId(),
               'materia' => $pergunta->getMateria()->getMateria(),
               'pergunta' => $pergunta->getPergunta(),
               'resposta' => $pergunta->getResposta()->toArray()
            ]);
        }
        return response()->json($perguntasCollection->toArray());
    }

    public function store(Request $request)
    {
        try {
        $pergunta = $this->provaFacade->createPergunta($request);
        $perguntaCollection = collect();
        $perguntaCollection->add([
            'id' => $pergunta->getId(),
            'pergunta' => $pergunta->getPergunta()
        ]);
        EntityManager::flush();
        return response()->json([$perguntaCollection], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

}