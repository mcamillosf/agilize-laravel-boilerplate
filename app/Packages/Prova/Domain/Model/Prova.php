<?php

namespace App\Packages\Prova\Domain\Model;

use App\Packages\User\Domain\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="provas")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Prova
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
    public string $status;

    /**
     * @ORM\Column(type="integer")
     */
    public int $qtdPerguntas;

    /**
     * @var Collection $perguntas
     * @ORM\ManyToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Pergunta",
     *     cascade={"all"},
     *     mappedBy="prova",
     *     fetch="EXTRA_LAZY"
     * )
     */
    protected Collection $perguntas;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="\App\Packages\User\Domain\Model\User",
     *     inversedBy="prova",
     *     cascade={"all"}
     * )
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Materia",
     *     inversedBy="prova",
     *     cascade={"persist"}
     * )
     */
    protected Materia $materia;

    /**
     * @param string $status
     * @param int $qtdPerguntas
     * @param Collection $perguntas
     * @param User $user
     * @param Materia $materia
     */
    public function __construct(string $status, int $qtdPerguntas, Collection $perguntas, User $user, Materia $materia)
    {
        $this->id = Str::uuid()->toString();
        $this->status = $status;
        $this->qtdPerguntas = $qtdPerguntas;
        $this->perguntas = $perguntas;
        $this->user = $user;
        $this->materia = $materia;
    }


    /**
     * @return Collection
     */
    public function getPerguntas(): Collection
    {
        return $this->perguntas;
    }

    /**
     * @param Collection $perguntas
     */
    public function setPerguntas(Collection $perguntas): void
    {
        $this->perguntas = $perguntas;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getQtdPerguntas(): int
    {
        return $this->qtdPerguntas;
    }

    /**
     * @param int $qtdPerguntas
     */
    public function setQtdPerguntas(int $qtdPerguntas): void
    {
        $this->qtdPerguntas = $qtdPerguntas;
    }
}