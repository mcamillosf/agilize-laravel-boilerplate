<?php

namespace App\Packages\Prova\Domain\Model;

/**
 * Pergunta
 */
class Pergunta
{
    /**
     * @var uuid
     */
    private $id;

    /**
     * @var string
     */
    private $pergunta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $resposta;

    /**
     * @var \App\Packages\Prova\Domain\Model\Prova
     */
    private $prova;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resposta = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
