<?php

namespace App\Packages\Prova\Domain\Model;

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
     * @ORM\GeneratedValue
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
     *    mappedBy="materia",
     *    cascade={"persist"}
     * )
     */
    protected Prova $prova;

    /**
     * @param string $materia
     * @param Prova $prova
     */
    public function __construct(string $materia, Prova $prova)
    {
        $this->id = Str::uuid()->toString();
        $this->materia = $materia;
        $this->prova = $prova;
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