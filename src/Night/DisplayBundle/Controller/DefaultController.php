<?php

namespace Night\DisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("hello/{name}", name="test")
     */
    public function indexAction($name)
    {
        return $this->render('NightDisplayBundle:Default:index.html.twig', array('name' => $name));
    }
}
