<?php

namespace App\Packages\Prova\Service;


use App\Packages\Prova\Domain\Repository\PerguntaRepository;
use App\Packages\Prova\Domain\Repository\RespostaRepository;

class RespostaService
{
    private RespostaRepository $respostaRepository;
    private PerguntaRepository $perguntaRepository;

    /**
     * @param RespostaRepository $respostaRepository
     * @param PerguntaRepository $perguntaRepository
     */
    public function __construct(RespostaRepository $respostaRepository, PerguntaRepository $perguntaRepository)
    {
        $this->respostaRepository = $respostaRepository;
        $this->perguntaRepository = $perguntaRepository;
    }

    public function createResposta($request)
    {
        $resposta_correta = $request->get('resposta_correta');
        $resposta = $request->get('resposta');
        $respostaId = $this->respostaRepository->getRespostaIdByResposta($resposta);
        if ($respostaId) {
            throw new \Exception('Resposta já cadastrada');
        }
        $pergunta = $request->get('pergunta');
        $perguntaI = $this->perguntaRepository->getPerguntaIdByPergunta($pergunta);
        if (!$perguntaI) {
            return 'Pergunta não encontrada!';
        }
        $perguntaId = $perguntaI['id']->toString();
        $res = $this->respostaRepository->createResposta($perguntaId, $resposta, $resposta_correta);

        return $res;
//        return 'oi';
    }

    /**
     * @param $respostaId
     * @return mixed
     */
    public function getRespostaById($respostaId): mixed
    {
        return $this->respostaRepository->getRespostaById($respostaId);
    }


    public function getRespostas()
    {
        return $this->respostaRepository->getRespostas();
    }

}