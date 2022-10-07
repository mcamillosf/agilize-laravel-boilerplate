<?php

namespace App\Packages\Prova\Tests\Unit\Service;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Repository\MateriaRepository;
use App\Packages\Prova\Service\MateriaService;
use Tests\TestCase;

class MateriaServiceTest extends TestCase
{
    public Materia $materia;

    public MateriaService $materiaService;

    public function testItCanCreateMateria()
    {
        $materia = [
            'id' => '1',
            'materia' => 'PHP'
        ];
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('createMateria')->willReturn($materia);

        $this->materiaService = new MateriaService($mockMateriaRepository);

        $result = $this->materiaService->createMateria('PHP');


        $this->assertEquals($materia, $result);
    }

    public function testItCantCreateMateriaIfAlreadyExist()
    {
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('getMateriaByName')->willReturn(true);

        $this->materiaService = new MateriaService($mockMateriaRepository);

        $this->expectExceptionMessage('Materia já cadastrada');

        $this->materiaService->createMateria('PHP');
    }

    public function testItWillReturnListOfMaterias()
    {
        $listaMateriasMock = [
            ['id' => '1' , 'materia' => 'Javascript'],
            ['id' => '2' , 'materia' => 'GO'],
            ['id' => '3' , 'materia' => 'PHP']
        ];
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('getMaterias')->willReturn($listaMateriasMock);

        $this->materiaService = new MateriaService($mockMateriaRepository);

        $result = $this->materiaService->getMaterias();

        $this->assertCount(3, $result);
    }
}