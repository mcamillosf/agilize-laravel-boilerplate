<?php

namespace App\Packages\Prova\Seed;


use App\Packages\Prova\Domain\Model\Materia;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class MateriasSeed extends Seeder
{
    public function run():void
    {
        $materiasSeeder = [
            ['materia' => 'Javascript'],
            ['materia' => 'PHP'],
        ];

        foreach ($materiasSeeder as $materiaSeed) {
            EntityManager::persist(new Materia($materiaSeed['materia']));
            EntityManager::flush();
        };
    }
}