<?php

namespace App\Http\Controllers\User;


use App\Packages\User\Facade\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    private UserFacade $userFacade;

    /**
     * @param UserFacade $userFacade
     */
    public function __construct(UserFacade $userFacade)
    {
        $this->userFacade = $userFacade;
    }

    public function index()
    {
        try {
        $students =  $this->userFacade->listarUsuarios();
        $studentsCollection = collect();
        foreach ($students as $student) {
            $studentsCollection->add([
                'id' => $student->getId(),
                'nome' => $student->getNome(),
            ]);
        }
        return response()->json($studentsCollection->toArray());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(Request $request)
    {
        try {
            $userId = $request->route('id');
            $user = $this->userFacade->getUserById($userId);
            $userCollection = collect();
            $userCollection->add([
                'id' => $user->getId(),
                'nome' => $user->getNome(),
            ]);
            return response()->json($userCollection[0]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
        $nome = $request->get('name');
        $student = $this->userFacade->criarUsuario($nome);
        return response()->json([$student], 201);
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
            $usuarioAtualizado = $this->userFacade->updateUser($id, $request->toArray());
            $userCollection = collect();
            $userCollection->add([
                'id' => $usuarioAtualizado->getId(),
                'nome' => $usuarioAtualizado->getNome(),
            ]);
            return response()->json($userCollection[0]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}