<?php

namespace App\Packages\Prova\Service;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Repository\MateriaRepository;

class MateriaService
{
    private MateriaRepository $materiaRepository;

    /**
     * @param MateriaRepository $materiaRepository
     */
    public function __construct(MateriaRepository $materiaRepository)
    {
        $this->materiaRepository = $materiaRepository;
    }

    public function createMateria($nomeMateria)
    {
        $mate = $this->materiaRepository->getMateriaByName($nomeMateria);
        if ($mate) {
            throw new \Exception('Materia já cadastrada');
        }
        $mat = $this->materiaRepository->createMateria($nomeMateria);

        return $mat;
    }

    public function getMateriaByName($materia)
    {
        return $this->materiaRepository->getMateriaByName($materia);
    }

    public function getMateriaById($materiaId)
    {
        return $this->materiaRepository->getMateriaById($materiaId);
    }

    public function getMaterias()
    {
        return $this->materiaRepository->getMaterias();
    }

    public function updateMateria($id, $request)
    {
        $materia = $request['materia'];
        $this->materiaRepository->updateMateria($id, $materia);
        return $this->getMateriaById($id);
    }
}