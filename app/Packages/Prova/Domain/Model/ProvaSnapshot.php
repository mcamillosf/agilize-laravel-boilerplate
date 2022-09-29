<?php

namespace App\Packages\Prova\Domain\Model;

use App\Packages\User\Domain\Model\User;
use Carbon\Carbon;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="provas_snapshot")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ProvaSnapshot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    public string $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $pergunta;

    /**
     * @ORM\Column(type="string")
     */
    public string $alternativa;

    /**
     * @ORM\Column(type="string")
     */
    public string $resposta_correta;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public string $resposta_marcada;


    /**
     * @ORM\ManyToOne(
     *     targetEntity="Prova",
     *     inversedBy="snapshot",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="prova_id")
     */
    public Prova $prova;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $inicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fim;

    public function __construct(Prova $prova, string $pergunta, string $alternativa, string $resposta_correta)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
        $this->alternativa = $alternativa;
        $this->resposta_correta = $resposta_correta;
        $this->prova = $prova;
        $this->inicio = Carbon::now();
        $this->fim = null;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPergunta(): string
    {
        return $this->pergunta;
    }

    /**
     * @param string $pergunta
     */
    public function setPergunta(string $pergunta): void
    {
        $this->pergunta = $pergunta;
    }

    /**
     * @return string
     */
    public function getAlternativa(): string
    {
        return $this->alternativa;
    }

    /**
     * @param string $alternativa
     */
    public function setAlternativa(string $alternativa): void
    {
        $this->alternativa = $alternativa;
    }

    /**
     * @return string
     */
    public function getRespostaCorreta(): string
    {
        return $this->resposta_correta;
    }

    /**
     * @param string $resposta_correta
     */
    public function setRespostaCorreta(string $resposta_correta): void
    {
        $this->resposta_correta = $resposta_correta;
    }

    /**
     * @return string
     */
    public function getRespostaMarcada(): string
    {
        return $this->resposta_marcada;
    }

    /**
     * @param string $resposta_marcada
     */
    public function setRespostaMarcada(string $resposta_marcada): void
    {
        $this->resposta_marcada = $resposta_marcada;
    }

    /**
     * @return Prova
     */
    public function getProva(): Prova
    {
        return $this->prova;
    }

    /**
     * @param Prova $prova
     */
    public function setProva(Prova $prova): void
    {
        $this->prova = $prova;
    }

    /**
     * @return DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param DateTime $inicio
     */
    public function setInicio(DateTime $inicio): void
    {
        $this->inicio = $inicio;
    }

    /**
     * @return DateTime
     */
    public function getFim()
    {
        return $this->fim;
    }

    /**
     * @param DateTime $fim
     */
    public function setFim(DateTime $fim): void
    {
        $this->fim = $fim;
    }
}