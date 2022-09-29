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
        return $this->userFacade->listarUsuarios();
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
}