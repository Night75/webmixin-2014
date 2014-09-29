<?php

namespace Night\DisplayBundle\Controller;

use Night\DisplayBundle\Util\ImageUtil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/show", name="project_show")
     * @Template
     */
    public function showAction()
    {
        /** @var \Night\DisplayBundle\Manager\ProjectManager $projectManager */
        $projectManager = $this->get('night_display.manager.project');
        $project = $projectManager->get(20);

        return ['project' => $project];
    }
}