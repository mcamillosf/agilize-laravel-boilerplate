<?php

namespace App\Packages\Prova\Tests\Unit\Service;


use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Repository\MateriaRepository;
use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use App\Packages\Prova\Service\MateriaService;
use App\Packages\Prova\Service\PerguntaService;
use Tests\TestCase;

class PerguntaServiceTest extends TestCase
{
    public Pergunta $pergunta;
    public PerguntaService $perguntaService;
    public MateriaRepository $materiaRepository;

    CONST perg = 'Os scripts de servidor PHP são cercados por delimitadores, quais?';
    CONST materia = ['id' => '1'];
    public function testItCanCreatePergunta()
    {
        $pergunta = [
            'id' => '1',
            'pergunta' => self::perg,
            'materia' => 'PHP'
        ];
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('getMateriaIdByName')->willReturn(self::materia);
        $this->app->bind(MateriaRepository::class, fn() => $mockMateriaRepository);
        $this->materiaRepository = app(MateriaRepository::class);
        $materiaResult = $this->materiaRepository->getMateriaIdByName('PHP');

        $mockPerguntaRepository = $this->createMock(PerguntaRepository::class);
        $mockPerguntaRepository->method('getPerguntaByPergunta')->willReturn(false);
        $mockPerguntaRepository->method('createPergunta')->willReturn($pergunta);
        $this->perguntaService = new PerguntaService($mockPerguntaRepository, $mockMateriaRepository);

        $result = $this->perguntaService->createPergunta(self::perg, $materiaResult);

        $this->assertEquals($pergunta, $result);
    }

    public function testItCantCreatePerguntaThatAlreadyExist()
    {
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('getMateriaIdByName')->willReturn(self::materia);
        $this->app->bind(MateriaRepository::class, fn() => $mockMateriaRepository);
        $this->materiaRepository = app(MateriaRepository::class);
        $materiaResult = $this->materiaRepository->getMateriaIdByName('PHP');

        $mockPerguntaRepository = $this->createMock(PerguntaRepository::class);
        $mockPerguntaRepository->method('getPerguntaByPergunta')->willReturn(true);
        $this->perguntaService = new PerguntaService($mockPerguntaRepository, $mockMateriaRepository);

        $this->expectExceptionMessage('Pergunta ja cadastrada no banco de dados!');

        $this->perguntaService->createPergunta(self::perg, $materiaResult);
    }

    public function testItCantCreatePerguntaWithoutMateria()
    {
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $mockMateriaRepository->method('getMateriaIdByName')->willReturn(false);
        $this->app->bind(MateriaRepository::class, fn() => $mockMateriaRepository);
        $this->materiaRepository = app(MateriaRepository::class);
        $materiaResult = $this->materiaRepository->getMateriaIdByName('PHP');

        $mockPerguntaRepository = $this->createMock(PerguntaRepository::class);
        $mockPerguntaRepository->method('getPerguntaByPergunta')->willReturn(false);
        $this->perguntaService = new PerguntaService($mockPerguntaRepository, $mockMateriaRepository);

        $this->expectExceptionMessage('Matéria não existe no banco de dados');

        $this->perguntaService->createPergunta(self::perg, $materiaResult);
    }

    public function testItWillListAllPerguntas()
    {
        $perguntas = [
            ['id' => '1', 'pergunta' => 'sei la', 'materia' => 'php'],
            ['id' => '2', 'pergunta' => 'talvez', 'materia' => 'php'],
            ['id' => '3', 'pergunta' => 'claro', 'materia' => 'php']
        ];
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $perguntaRepositoryMock->method('getPerguntas')->willReturn($perguntas);
        $this->perguntaService = new PerguntaService($perguntaRepositoryMock, $mockMateriaRepository);

        $result = $this->perguntaService->getPerguntas();

        $this->assertEquals($perguntas, $result);
    }

    public function testItWillReturnOnePergunta()
    {
        $pergunta = ['id' => '1', 'pergunta' => 'sei la', 'materia' => 'php'];
        $mockMateriaRepository = $this->createMock(MateriaRepository::class);
        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $perguntaRepositoryMock->method('getPerguntaById')->willReturn($pergunta);
        $this->perguntaService = new PerguntaService($perguntaRepositoryMock, $mockMateriaRepository);

        $result = $this->perguntaService->getPerguntaById('1');

        $this->assertEquals($pergunta, $result);
    }
}