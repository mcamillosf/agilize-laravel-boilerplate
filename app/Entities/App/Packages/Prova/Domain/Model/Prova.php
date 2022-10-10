<?php

namespace App\Packages\Prova\Domain\Model;

/**
 * Prova
 */
class Prova
{
    /**
     * @var uuid
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $qtdPerguntas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $perguntas;

    /**
     * @var \App\Packages\User\Domain\Model\User
     */
    private $user;

    /**
     * @var \App\Packages\Prova\Domain\Model\Materia
     */
    private $materia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->perguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
