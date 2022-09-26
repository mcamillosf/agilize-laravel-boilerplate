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
 * @ORM\Table(name="provas")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Prova
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $inicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fim;

    /**
     * @ORM\OneToMany(
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
     * @ORM\JoinColumn(name="materia_id")
     */
    protected Materia $materia;

    public function __construct(string $status = '', ?int $qtdPerguntas = 10, User $user, Materia $materia)
    {
        $this->id = Str::uuid()->toString();
        $this->materia = $materia;
        $this->status = $status;
        $this->qtdPerguntas = $qtdPerguntas;
        $this->perguntas = new ArrayCollection();
        $this->user = $user;
        $this->inicio = Carbon::now('America/Sao_Paulo');
        $this->fim = null;
    }


    /**
     * @return Collection
     */
    public function getPerguntas(): Collection
    {
        return $this->perguntas;
    }

    public function addPerguntas($perguntas): void
    {
        foreach ($perguntas as $pergunta) {
            $this->perguntas->add($pergunta);
        }
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio): void
    {
        $this->inicio = $inicio;
    }

    /**
     * @return DateTime
     */
    public function getFim(): DateTime
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