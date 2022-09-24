<?php

namespace App\Packages\Prova\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="respostas")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Resposta
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    public string $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $resposta;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $respostaCorreta;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Pergunta",
     *     inversedBy="resposta",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="pergunta_id")
     */
    protected Pergunta $pergunta;

    /**
     * @param string $resposta
     * @param string $respostaCorreta
     * @param Pergunta $pergunta
     */
    public function __construct(string $resposta, string $respostaCorreta, Pergunta $pergunta)
    {
        $this->id = Str::uuid()->toString();
        $this->resposta = $resposta;
        $this->respostaCorreta = $respostaCorreta;
        $this->pergunta = $pergunta;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getResposta(): string
    {
        return $this->resposta;
    }

    /**
     * @param string $resposta
     */
    public function setResposta(string $resposta): void
    {
        $this->resposta = $resposta;
    }

    /**
     * @return string
     */
    public function getRespostaCorreta(): string
    {
        return $this->respostaCorreta;
    }

    /**
     * @param string $respostaCorreta
     */
    public function setRespostaCorreta(string $respostaCorreta): void
    {
        $this->respostaCorreta = $respostaCorreta;
    }

    /**
     * @return Pergunta
     */
    public function getPergunta(): Pergunta
    {
        return $this->pergunta;
    }

    /**
     * @param Pergunta $pergunta
     */
    public function setPergunta(Pergunta $pergunta): void
    {
        $this->pergunta = $pergunta;
    }

}