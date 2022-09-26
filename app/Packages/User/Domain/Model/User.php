<?php

namespace App\Packages\User\Domain\Model;

use App\Packages\Prova\Domain\Model\Prova;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="users")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    public string $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $nome;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\Prova",
     *     cascade={"all"},
     *     mappedBy="user",
     *     fetch="EXTRA_LAZY"
     * )
     */
    protected Collection $prova;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\App\Packages\Prova\Domain\Model\ProvaSnapshot",
     *     cascade={"all"},
     *     mappedBy="user",
     *     fetch="EXTRA_LAZY"
     * )
     */
    protected Collection $prova_snapshot;

    /**
     * @param string $nome
     */
    public function __construct(string $nome = '')
    {
        $this->id = Str::uuid()->toString();
        $this->nome = $nome;
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
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return Collection
     */
    public function getProvaSnapshot(): Collection
    {
        return $this->prova_snapshot;
    }

    /**
     * @param Collection $prova_snapshot
     */
    public function setProvaSnapshot(Collection $prova_snapshot): void
    {
        $this->prova_snapshot = $prova_snapshot;
    }

}