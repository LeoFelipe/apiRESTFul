<?php
namespace Api\Model;


class Model
{
    private $em,
            $entity;

    public function __construct($entityManager, $entity)
    {
        $this->em = $entityManager;
        $this->entity = $entity;
    }

    protected function getEM()
    {
        return $this->em;
    }

    protected function getEntity()
    {
        return $this->entity;
    }


    /***********************************
     * Default Repositories Methods
     **********************************/
    public function findAll()
    {
        return $this->em->getRepository($this->entity)->findAll();
    }

    public function find($id)
    {
        return $this->em->getRepository($this->entity)->find($id);
    }

    public function findBy(Array $criteria)
    {
        return $this->em->getRepository($this->entity)->findBy($criteria);
    }

    public function findOneBy(Array $criteria)
    {
        return $this->em->getRepository($this->entity)->findOneBy($criteria);
    }


}