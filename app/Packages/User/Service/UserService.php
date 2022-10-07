<?php

namespace App\Packages\User\Service;


use App\Packages\User\Domain\Model\User;
use App\Packages\User\Domain\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($name)
    {
        $user = $this->userRepository->findUserByName($name);
        if ($user) {
            throw new \Exception('Usuário já cadastrado');
        }
        return $this->userRepository->createUser($name);
    }

    public function update(User $user)
    {
        $this->userRepository->update($user);
    }

    public function getUserIdByName($name)
    {
        return $this->userRepository->getUserIdByName($name);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function updateUser($id, $request)
    {
        $nome = $request['nome'];
        $this->userRepository->updateUser($id, $nome);
        return $this->userRepository->getUserById($id);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }
}