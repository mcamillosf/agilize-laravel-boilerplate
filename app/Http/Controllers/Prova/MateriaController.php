<?php

namespace App\Http\Controllers\Prova;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Facade\ProvaFacade;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelDoctrine\ORM\Facades\EntityManager;

class MateriaController extends Controller
{
    private ProvaFacade $provaFacade;

    public function __construct(ProvaFacade $provaFacade)
    {
        $this->provaFacade = $provaFacade;
    }

    public function index()
    {
        /** @var Materia $materias*/
        $materias =  $this->provaFacade->getMaterias();
        $materiasCollection = collect();
        foreach ($materias as $materia) {
        $materiasCollection->add([
            'id' => $materia->getId(),
            'materia' => $materia->getMateria()
        ]);
        }
        return response()->json($materiasCollection->toArray());
    }

    public function store(Request $request)
    {
        try {
            $nomeMateria = $request->get('materia');
            $materia = $this->provaFacade->createMateria($nomeMateria);
            $materiaCollection = collect();
            $materiaCollection->add([
                'id' => $materia->getId(),
                'materia' => $materia->getMateria()
            ]);
            EntityManager::flush();
            return response()->json([$materiaCollection[0]], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(Request $request)
    {
        try {
            $materiaId = $request->route('id');
            $materia = $this->provaFacade->getMateriaById($materiaId);
            $materiaCollection = collect();
            $materiaCollection->add([
                'id' => $materia->getId(),
                'materia' => $materia->getMateria(),
            ]);
            return response()->json($materiaCollection[0]);
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
            $materiaAtualizada = $this->provaFacade->updateMateria($id, $request->toArray());
            $materiaCollection = collect();
            $materiaCollection->add([
                'id' => $materiaAtualizada->getId(),
                'materia' => $materiaAtualizada->getMateria(),
            ]);
            return response()->json($materiaCollection[0]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}