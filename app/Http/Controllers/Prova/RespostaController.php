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
        $resposta = $this->provaFacade->createResposta($request);
        $respostasCollection = collect();
            $respostasCollection->add([
                'id' => $resposta->getId(),
                'resposta' => $resposta->getResposta(),
                'resposta_correta' => (boolean)$resposta->getRespostaCorreta()
            ]);

        EntityManager::flush();
        return response()->json($respostasCollection->toArray());
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}