<?php

namespace App\Packages\Base;


use LaravelDoctrine\ORM\Facades\EntityManager;

class Repository extends AbstractRepository
{
    /**
     * @param object $entity
     * @return void
     */
    public function add(object $entity)
    {
        EntityManager::persist($entity);
    }

    /**
     * @param object $entity
     * @return void
     */
    public function remove(object $entity)
    {
        EntityManager::remove($entity);
    }

    /**
     * @param object $entity
     * @return object
     */
    public function update(object $entity)
    {
        return EntityManager::merge($entity);
    }

    public function flush()
    {
        EntityManager::flush();
    }
}