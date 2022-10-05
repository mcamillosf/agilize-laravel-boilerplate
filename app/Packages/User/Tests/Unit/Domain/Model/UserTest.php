<?php

namespace App\Packages\User\Tests\Unit\Domain\Model;


use App\Packages\User\Domain\Model\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $nome = 'Joao Silva';
        $this->user = new User($nome);
    }
}