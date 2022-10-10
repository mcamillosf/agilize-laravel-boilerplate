<?php

namespace App\Packages\Prova\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="perguntas")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Pergunta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $pergunta;


    /**
     * @var Collection $resposta
     * @ORM\OneToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Resposta",
     *     mappedBy="pergunta",
     *     cascade={"persist"}
     * )
     */
    protected Collection $resposta;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Prova",
     *     inversedBy="pergunta",
     *     cascade={"persist"}
     * )
     */
    protected Prova $prova;

    /**
     * @param string $pergunta
     * @param Resposta $resposta
     * @param Prova $prova
     */
    public function __construct(string $pergunta, Resposta $resposta, Prova $prova)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
        $this->resposta = new ArrayCollection();
        $this->prova = $prova;
    }

    /**
     * @return Collection
     */
    public function getResposta(): Collection
    {
        return $this->resposta;
    }

    /**
     * @param Collection $resposta
     */
    public function setResposta(Collection $resposta): void
    {
        $this->resposta = $resposta;
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
}