<?php

namespace App\Packages\User\Facade;


use App\Packages\User\Service\UserService;

class UserFacade
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function criarUsuario($nome)
    {
        return $this->userService->create($nome);
    }

    public function listarUsuarios()
    {
        return $this->userService->getAllUsers();
    }

    public function getUserIdByName($nome)
    {
        return $this->userService->getUserIdByName($nome);
    }

    public function updateUser($id, $request)
    {
        return $this->userService->updateUser($id, $request);
    }

    public function getUserById($id)
    {
        return $this->userService->getUserById($id);
    }
}