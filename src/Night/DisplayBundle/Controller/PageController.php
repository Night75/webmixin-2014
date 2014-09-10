<?php

namespace Night\DisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="page_home")
     * @Template
     */
    public function homeAction()
    {
        return [];
    }

    /**
     * @Route("/skills", name="page_contact")
     * @Template
     */
    public function skillsAction()
    {
        return [];
    }

    /**
     * @Route("/projects", name="page_projects")
     * @Template
     */
    public function projectsAction()
    {
        return [];
    }

    /**
     * @Route("/about-me", name="page_about_me")
     * @Template
     */
    public function aboutMeAction()
    {
        return [];
    }

    /**
     * @Route("/contact", name="page_contact")
     * @Template
     */
    public function contactAction()
    {
        return [];
    }
}
