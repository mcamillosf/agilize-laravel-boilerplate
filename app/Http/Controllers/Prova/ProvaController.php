<?php

namespace App\Http\Controllers\Prova;


use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Facade\ProvaFacade;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProvaController extends Controller
{
    private ProvaFacade $provaFacade;

    public function __construct(ProvaFacade $provaFacade)
    {
        $this->provaFacade = $provaFacade;
    }

    public function store(Request $request)
    {
        try {
        $prova = $this->provaFacade->createProva($request);
            EntityManager::flush();
            return response()->json([$prova], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }

    }

    public function index()
    {
        try {
            $provas = $this->provaFacade->getProvas();
            $provasCollection = collect();
            /** @var Prova $prova */
            foreach ($provas as $prova) {
                $provasCollection->add([
                    'prova_id' => $prova->getId(),
                    'aluno' => $prova->getUser()->getNome(),
                    'materia' => $prova->getMateria()->getMateria(),
                ]);
            }
            return response()->json($provasCollection->toArray());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
        $id = $request->route('id');
        $provaFinalizada = $this->provaFacade->finalizarProva($request->toArray(), $id);
        $provaResultado = $this->getResultadoProva($provaFinalizada);
        return response()->json($provaResultado[0]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * @param mixed $provaFinalizada
     * @return Collection
     */
    public function getResultadoProva(mixed $provaFinalizada): Collection
    {
        $perguntas = $provaFinalizada->getSnapshot()->toArray();
        $perguntasCollection = collect();
        foreach ($perguntas as $pergunta) {
            $perguntasCollection->add([
                'pergunta' => $pergunta->getPergunta(),
                'alternativa_correta' => $pergunta->getRespostaCorreta(),
                'alternativa_marcada' => $pergunta->getRespostaMarcada(),
            ]);
        }
        $provaCollection = collect();
        /** @var Prova $prova */
        $provaCollection->add([
            'prova_id' => $provaFinalizada->getId(),
            'aluno' => $provaFinalizada->getUser()->getNome(),
            'prova_status' => $provaFinalizada->getStatus(),
            'materia_prova' => $provaFinalizada->getMateria()->getMateria(),
            'quantidade_perguntas' => $provaFinalizada->getQtdPerguntas(),
            'nota_prova' => $provaFinalizada->getNotaProva(),
            'gabarito' => $perguntasCollection->toArray()
        ]);
        return $provaCollection;
    }
}