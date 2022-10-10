<?php

namespace App\Packages\Prova\Tests\Unit\Service;


use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Resposta;
use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use App\Packages\Prova\Domain\Repository\RespostaRepository;
use App\Packages\Prova\Service\RespostaService;
use Tests\TestCase;

class RespostaServiceTest extends TestCase
{
    public Resposta $resposta;
    public RespostaService $respostaService;
    public PerguntaRepository $perguntaRepository;

    public function testItCanCreateResposta()
    {
        $pergunta = ['id' => '1', 'pergunta' => 'que dia e hoje', 'materia' => 'sei la'];
        $resposta = ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true];

        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $respostaRepositoryMock->method('getRespostaIdByResposta')->willReturn(false);
        $respostaRepositoryMock->method('createResposta')->willReturn($resposta);

        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $perguntaRepositoryMock->method('getPerguntaById')->willReturn($pergunta);
        $this->app->bind(PerguntaRepository::class, fn() => $perguntaRepositoryMock);
        $this->perguntaRepository = app(PerguntaRepository::class);

        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $perguntaResult = $this->perguntaRepository->getPerguntaById('1');

        $result = $this->respostaService->createResposta($perguntaResult, 'sexta', true);

        $this->assertEquals($resposta, $result);
    }

    public function testItCantCreateRespostaThatAlreadyExist()
    {
        $pergunta = ['id' => '1', 'pergunta' => 'que dia e hoje', 'materia' => 'sei la'];
        $resposta = ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true];

        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $respostaRepositoryMock->method('getRespostaIdByResposta')->willReturn(true);
        $respostaRepositoryMock->method('createResposta')->willReturn($resposta);

        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $perguntaRepositoryMock->method('getPerguntaByPergunta')->willReturn($pergunta);
        $this->app->bind(PerguntaRepository::class, fn() => $perguntaRepositoryMock);
        $this->perguntaRepository = app(PerguntaRepository::class);

        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $this->expectExceptionMessage('Resposta já cadastrada');

        $this->respostaService->createResposta($pergunta, 'sexta', true);
    }

    public function testItCantCreateRespostaWithoutPergunta()
    {
        $pergunta = ['id' => '1', 'pergunta' => 'que dia e hoje', 'materia' => 'sei la'];
        $resposta = ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true];

        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $respostaRepositoryMock->method('getRespostaIdByResposta')->willReturn(false);
        $respostaRepositoryMock->method('createResposta')->willReturn($resposta);

        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $perguntaRepositoryMock->method('getPerguntaByPergunta')->willReturn(false);
        $this->app->bind(PerguntaRepository::class, fn() => $perguntaRepositoryMock);
        $this->perguntaRepository = app(PerguntaRepository::class);

        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $this->expectExceptionMessage('Pergunta não encontrada!');

        $this->respostaService->createResposta($pergunta, 'sexta', true);
    }

    public function testItWillListAllRespostas()
    {
        $respostas = [
            ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true],
            ['id' => '2', 'resposta' => 'domingo', 'resposta_correta' => false],
            ['id' => '3', 'resposta' => 'sábado', 'resposta_correta' => false],
            ['id' => '4', 'resposta' => 'segunda', 'resposta_correta' => false],
            ['id' => '5', 'resposta' => 'php', 'resposta_correta' => true],
            ['id' => '6', 'resposta' => 'javascript', 'resposta_correta' => false],
            ['id' => '7', 'resposta' => 'go', 'resposta_correta' => false],
            ['id' => '8', 'resposta' => 'java', 'resposta_correta' => false],
        ];
        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $respostaRepositoryMock->method('getRespostaIdByResposta')->willReturn(false);
        $respostaRepositoryMock->method('getRespostas')->willReturn($respostas);
        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $result = $this->respostaService->getRespostas();

        $this->assertCount(8, $result);
    }

    public function testItWillListOnlyOneResposta()
    {
        $resposta = ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true];
        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $respostaRepositoryMock->method('getRespostaById')->willReturn($resposta);
        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $result = $this->respostaService->getRespostaById('1');

        $this->assertEquals($resposta, $result);
    }

    public function testItCantShowRespostaThatWasNotCreated()
    {
        $resposta = ['id' => '1', 'resposta' => 'sexta', 'resposta_correta' => true];
        $respostaRepositoryMock = $this->createMock(RespostaRepository::class);
        $perguntaRepositoryMock = $this->createMock(PerguntaRepository::class);
        $respostaRepositoryMock->method('getRespostaById')->willReturn(false);
        $this->respostaService = new RespostaService($respostaRepositoryMock, $perguntaRepositoryMock);

        $this->expectExceptionMessage('Resposta não encontrada');

        $this->respostaService->getRespostaById('1');
    }
}