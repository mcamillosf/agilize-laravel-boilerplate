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
            return response()->json($provas->toArray());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(Request $request)
    {
        try {
            $id = $request->route('id');
            $prova = $this->provaFacade->getProvaById($id);
            return response()->json($prova->toArray());
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
        return response()->json($provaFinalizada);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}