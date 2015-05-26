<?php

namespace Night\DisplayBundle\Manager;

use Doctrine\ORM\EntityNotFoundException;
use Night\DisplayBundle\Dao\BaseDao;
use Night\DisplayBundle\Entity\Project;
use Night\DisplayBundle\Exception\ModelNotFoundException;

abstract class BaseManager
{
    /** @var BaseDao */
    protected $dao;

    public function __construct(BaseDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param $id
     *
     * @return Project
     *
     * @throws ModelNotFoundException
     */
    public function get($id)
    {
        $model = $this->dao->find($id);
        if (!$model) {
            throw new ModelNotFoundException(
                sprintf('Model "%s" with the id %s was not found.', $this->getModelClass(), $id)
            );
        }

        return $model;
    }

    public function getPrevious($id)
    {
        return $this->dao->findPrevious($id);
    }

    public function getNext($id)
    {
        return $this->dao->findNext($id);
    }

    public function getAll()
    {
        return $this->dao->findAll();
    }

    public function getModelClass()
    {
        return $this->dao->getEntityClass();
    }
}