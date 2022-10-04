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

    public function createMateria($request)
    {
        $materia = $request->get('materia');
        $mate = $this->materiaRepository->getMateriaByName($materia);
        if ($mate) {
            throw new \Exception('Materia já cadastrada');
        }
        $mat = $this->materiaRepository->createMateria($materia);

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
        return $this->materiaRepository->updateMateria($id, $materia);
    }
}