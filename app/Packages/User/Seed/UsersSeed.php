<?php

namespace App\Packages\User\Seed;


use App\Packages\User\Domain\Model\User;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UsersSeed extends Seeder
{
    public function run(): void
    {
        $usersSeeder = [
            ['nome' => 'John Doe'],
            ['nome' => 'Jane Doe'],
        ];

        foreach ($usersSeeder as $userSeed) {
            EntityManager::persist(new User($userSeed['nome']));
            EntityManager::flush();
        }
    }
}