<?php

namespace Night\DisplayBundle\Manager;

use Night\DisplayBundle\Dao\ProjectDao;

class ProjectManager extends BaseManager
{
    public function __construct(ProjectDao $dao)
    {
        parent::__construct($dao);
    }
}
