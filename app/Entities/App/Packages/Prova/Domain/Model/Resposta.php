<?php

namespace App\Packages\Prova\Domain\Model;

/**
 * Resposta
 */
class Resposta
{
    /**
     * @var uuid
     */
    private $id;

    /**
     * @var string
     */
    private $resposta;

    /**
     * @var bool
     */
    private $respostaCorreta;

    /**
     * @var \App\Packages\Prova\Domain\Model\Pergunta
     */
    private $pergunta;


}
