<?php

namespace App\Packages\Prova\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Str;
use function Sodium\add;

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
     * @ORM\Column(type="uuid")
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
     *     cascade={"all"},
     *     fetch="EXTRA_LAZY"
     * )
     */
    protected Collection $resposta;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Prova",
     *     inversedBy="prova",
     *     cascade={"persist"}
     * )
     */
    protected Collection $prova;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Materia",
     *     inversedBy="pergunta",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="materia_id")
     */
    private Materia $materia;

    /**
     * @param string $pergunta
     * @param Materia $materia
     */
    public function __construct(string $pergunta, Materia $materia)
    {
        $this->id = Str::uuid()->toString();
        $this->pergunta = $pergunta;
        $this->materia = $materia;
        $this->resposta = new ArrayCollection();
    }

    /**
     * @return Materia
     */
    public function getMateria(): Materia
    {
        return $this->materia;
    }

    /**
     * @param Materia $materia
     */
    public function setMateria(Materia $materia): void
    {
        $this->materia = $materia;
    }

    /**
     * @return Collection
     */
    public function getResposta(): Collection
    {
        return $this->resposta;
    }

    /**
     * @param Resposta $resposta
     */
    public function addResposta(Resposta $resposta): void
    {
        $this->resposta->add($resposta);
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
     * @return Collection
     */
    public function getProva(): Collection
    {
        return $this->prova;
    }

    /**
     * @param Collection $prova
     */
    public function setProva(Collection $prova): void
    {
        $this->prova = $prova;
    }

    public function adicionaRespostaAPergunta(Resposta $resposta)
    {

    }
}