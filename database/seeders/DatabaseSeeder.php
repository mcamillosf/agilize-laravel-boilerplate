<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Packages\Prova\Seed\MateriasSeed;
use App\Packages\Prova\Seed\PerguntasSeed;
use App\Packages\Prova\Seed\RespostasSeed;
use App\Packages\User\Seed\UsersSeed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            MateriasSeed::class,
            PerguntasSeed::class,
            RespostasSeed::class,
            UsersSeed::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
