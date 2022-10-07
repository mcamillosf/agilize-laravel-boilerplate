<?php

namespace App\Packages\User\Tests\Unit\Service;


use App\Packages\User\Domain\Model\User;
use App\Packages\User\Domain\Repository\UserRepository;
use App\Packages\User\Service\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public User $user;

    public UserService $userService;

    public function testItCanCreateUser()
    {
        $this->userService = app(UserService::class);
        $result = $this->userService->create('Joao da Silva');

        $this->assertInstanceOf(User::class, $result);
    }

    public function testItCannotCreateUserThatAlreadyExist()
    {
        $mockUserRepository = $this->createMock(UserRepository::class);
        $mockUserRepository->method('findUserByName')->willReturn(true);
        $this->userService = new UserService($mockUserRepository);

        $this->expectExceptionMessage('Usuário já cadastrado');

        $this->userService->create('Joao da Silva');
    }

    public function testItWillReturnListOfUsers()
    {
        // given
        $mockListUser = [
            ['id' => '1', 'nome' => 'Joao da Silva'],
            ['id' => '2', 'nome' => 'Jose da Silva']
        ];
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock->method('getAllUsers')->willReturn($mockListUser);
        $this->userService = new UserService($userRepositoryMock);

        // when
        $result = $this->userService->getAllUsers();

        // then
        $this->assertCount(2, $result);
    }

//    public function testeItWillUpdateUser()
//    {
//
//    }
}