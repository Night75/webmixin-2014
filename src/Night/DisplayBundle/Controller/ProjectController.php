<?php

namespace Night\DisplayBundle\Controller;

use Night\DisplayBundle\Util\ImageUtil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/*
 * @Route("/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route(
     *  "/show/{id}",
     *  name="project_show",
     *  requirements={"id"="\d+"}
     * )
     */
    public function showAction(Request $request, $id)
    {
        $template = $request->isXmlHttpRequest() ?
            'NightDisplayBundle:Project:show_content.html.twig' :
            'NightDisplayBundle:Project:show.html.twig' ;

        /** @var \Night\DisplayBundle\Manager\ProjectManager $projectManager */
        $projectManager = $this->get('night_display.manager.project');

        $project = $projectManager->get($id);
        $previousProject = $projectManager->getPrevious($id);
        $nextProject = $projectManager->getNext($id);

        $tech = $project->getWebTechnologies();
        $c = count($tech);

        return $this->render($template, [
                'project' => $project,
                'previousProject' => $previousProject,
                'nextProject' => $nextProject,
                'activePage' => 'annex',
            ]);
    }
}