<?php

namespace App\Http\Controllers\Prova;


use App\Packages\Prova\Domain\Model\Prova;
use App\Packages\Prova\Facade\ProvaFacade;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $provaCollection = collect();
        $provaCollection->add([
            'prova_id' => $prova->getId(),
            'aluno' => $prova->getUser()->getNome(),
            'materia_prova' => $prova->getMateria()->getMateria(),
            'quantidade_perguntas' => $prova->getQtdPerguntas(),
            'perguntas' => $prova->getPerguntas()->toArray()
        ]);
            EntityManager::flush();
            return response()->json($provaCollection->toArray());
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
                    'quantidade_perguntas' => $prova->getPerguntas(),
                    'perguntas' => $prova->getPerguntas()->toArray()
                ]);
            }
            return response()->json($provasCollection->toArray());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}