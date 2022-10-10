<?php

namespace App\Http\Controllers\Prova;


use App\Http\Controllers\Controller;
use App\Packages\Prova\Domain\Model\Resposta;
use App\Packages\Prova\Facade\ProvaFacade;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RespostaController extends Controller
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
        /** @var Resposta $resposta */
        $respostas = $this->provaFacade->getRespostas();
        $respostasCollection = collect();
        foreach ($respostas as $resposta) {
            $respostasCollection->add([
                'id' => $resposta->getId(),
                'resposta' => $resposta->getResposta(),
                'resposta_correta' => (boolean)$resposta->getRespostaCorreta()
            ]);
        }
        return response()->json($respostasCollection->toArray());
    }

    public function store(Request $request)
    {
        try {
        $resposta_correta = $request->get('resposta_correta');
        $resposta = $request->get('resposta');
        $pergunta = $request->get('pergunta');
        $resposta = $this->provaFacade->createResposta($pergunta, $resposta, $resposta_correta);
        $respostasCollection = collect();
            $respostasCollection->add([
                'id' => $resposta->getId(),
                'resposta' => $resposta->getResposta(),
                'resposta_correta' => (boolean)$resposta->getRespostaCorreta()
            ]);

        EntityManager::flush();
        return response()->json([$respostasCollection[0]], 201);
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(Request $request)
    {
        try {
        $respostaId = $request->route('id');
        $resposta = $this->provaFacade->getRespostaById($respostaId);
        $respostaCollection = collect();
        $respostaCollection->add([
            'id' => $resposta->getId(),
            'alternativa' => $resposta->getResposta(),
            'resposta_correta' => (boolean)$resposta->getRespostaCorreta(),
        ]);
        return response()->json($respostaCollection[0]);
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
            $respostaAtualizada = $this->provaFacade->updateResposta($id, $request->toArray());
            $respostaCollection = collect();
            $respostaCollection->add([
                'id' => $respostaAtualizada->getId(),
                'resposta' => $respostaAtualizada->getResposta(),
                'resposta_correta' => (boolean)$respostaAtualizada->getRespostaCorreta(),
            ]);
            return response()->json($respostaCollection[0]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}