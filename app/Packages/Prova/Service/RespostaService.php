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
    }

    public function getRespostaById($respostaId)
    {
        $resposta = $this->respostaRepository->getRespostaById($respostaId);

        if (!$resposta) {
            throw new \Exception('Resposta não encontrada');
        }

        return $resposta;
    }

    public function updateRespostaById($id, $request)
    {
        $resposta = $request['resposta'];
        $resposta_correta = $request['resposta_correta'];
        if ($resposta_correta === null) {
             $this->respostaRepository->updateResposta($id, $resposta);
             return $this->getRespostaById($id);
        }
        if ($resposta === null) {
             $this->respostaRepository->updateRespostaCorreta($id, $resposta_correta);
            return $this->getRespostaById($id);
        }
        $this->respostaRepository->updateRespostaAndRespostaCorreta($id, $resposta, $resposta_correta);
        return $this->getRespostaById($id);
    }

    public function getRespostas()
    {
        return $this->respostaRepository->getRespostas();
    }

}