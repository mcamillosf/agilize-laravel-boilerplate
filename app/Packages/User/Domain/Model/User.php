<?php

namespace App\Packages\User\Domain\Model;

use App\Packages\Prova\Domain\Model\Prova;
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
     * @ORM\GeneratedValue
     * @ORM\Column(type="uuid", unique=true)
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
    protected Prova $prova;

    /**
     * @param string $nome
     * @param Prova $prova
     */
    public function __construct(string $nome, Prova $prova)
    {
        $this->id = Str::uuid()->toString();
        $this->nome = $nome;
        $this->prova = $prova;
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

}