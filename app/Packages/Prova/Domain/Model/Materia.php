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
 * @ORM\Table(name="materias")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Materia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    public string $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $materia;

    /**
     * @ORM\OneToMany(
     *    targetEntity="\App\Packages\Prova\Domain\Model\Prova",
     *    cascade={"all"},
     *    mappedBy="materia",
     *    fetch="EXTRA_LAZY"
     * )
     */
    protected Collection $prova;

    /**
     * @var Collection $pergunta
     * @ORM\OneToMany(
     *   targetEntity="Pergunta",
     *   cascade={"persist"},
     *   mappedBy="materia",
     *   fetch="EXTRA_LAZY"
     * )
     */
    private Collection $pergunta;

    /**
     * @param string $materia
     */
    public function __construct(string $materia = '')
    {
        $this->id = Str::uuid()->toString();
        $this->materia = $materia;
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
    public function getMateria(): string
    {
        return $this->materia;
    }

    /**
     * @param string $materia
     */
    public function setMateria(string $materia): void
    {
        $this->materia = $materia;
    }

    /**
     * @return Collection
     */
    public function getProva(): Collection
    {
        return $this->prova;
    }

    /**
     * @param Prova $prova
     */
    public function setProva(Collection $prova): void
    {
        $this->prova = $prova;
    }

    /**
     * @return Collection
     */
    public function getPergunta(): Collection
    {
        return $this->pergunta;
    }

    /**
     * @param Collection $pergunta
     */
    public function setPergunta(Collection $pergunta): void
    {
        $this->pergunta = $pergunta;
    }
}