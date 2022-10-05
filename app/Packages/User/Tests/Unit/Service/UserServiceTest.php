<?php

namespace App\Packages\User\Tests\Unit\Service;


use App\Packages\User\Domain\Model\User;
use App\Packages\User\Service\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public User $user;

    public UserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User('Joao da Silva');
        $this->userService = app(UserService::class);
    }

    public function testItCanCreateUser()
    {
        
    }
}