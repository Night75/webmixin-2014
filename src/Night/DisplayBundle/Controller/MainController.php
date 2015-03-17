<?php

namespace Night\DisplayBundle\Controller;

use Night\DisplayBundle\Util\ImageUtil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="main_main")
     * @Template
     */
    public function mainAction(Request $request)
    {
        $template = $request->isXmlHttpRequest() ?
            'NightDisplayBundle:Main:main_content.html.twig' :
            'NightDisplayBundle:Main:main.html.twig' ;

        return $this->render($template, ['pageType' => 'main']);
    }

    /**
     * @Route("/home", name="main_home")
     * @Template
     */
    public function homeAction()
    {
        return [];
    }

    /**
     * @Route("/skills", name="main_contact")
     * @Template
     */
    public function skillsAction()
    {
        // core, server-1, server-2, script, design, core
        $skills = [
            ['utility', 'Git'], ['utility' , 'SVN'], ['core', 'npm'], ['core', 'Less'],
            ['core', 'Composer'], ['utility', 'Bower'], ['script', 'Bootstrap'],
            ['design', 'Photoshop'], ['design', 'Illustrator'], ['server-2', 'Apache'], ['server-2', 'Nginx'],
            ['server-2', 'Varnish'], ['design', 'SVG'], ['database', 'MongoDB'], ['database', 'MySQL'],
            ['utility', 'jenkins'], ['utility', 'selenium'], ['server', 'Joomla'], ['server', 'Magento'],
        ];

        shuffle($skills);

        return [
            'skills' => $skills
        ];
    }

    /**
     * @Route("/projects", name="main_projects")
     * @Template
     */
    public function projectsAction()
    {
        /** @var \Night\DisplayBundle\Manager\ProjectManager $projectManager */
        $projectManager = $this->get('night_display.manager.project');
        $projects = $projectManager->getAll();

        return ['projects' => $projects];
    }

    /**
     * @Route("/about-me", name="main_about_me")
     * @Template
     */
    public function aboutMeAction()
    {
        return [];
    }

    /**
     * @Route("/contact", name="main_contact")
     * @Template
     */
    public function contactAction()
    {
        return [];
    }
}
