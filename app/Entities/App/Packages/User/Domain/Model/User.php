<?php

namespace App\Packages\User\Domain\Model;

/**
 * User
 */
class User
{
    /**
     * @var uuid
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $prova;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prova = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
