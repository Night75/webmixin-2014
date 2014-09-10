<?php

namespace Night\DisplayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    public function headerAction()
    {
        return $this->render('NightDisplayBundle::header.html.twig');
    }
}
