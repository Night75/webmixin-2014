<?php

namespace Night\DisplayBundle\Dao;

use Night\DisplayBundle\Entity\Project;

class ProjectDao extends BaseDao
{
    /**
     * @return string the fully qualified class name managed by the dao
     */
    public function getEntityClass()
    {
        return Project::class;
    }
}