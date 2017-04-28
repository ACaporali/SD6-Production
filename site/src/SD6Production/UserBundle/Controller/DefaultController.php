<?php

namespace SD6Production\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SD6ProductionUserBundle:Default:index.html.twig');
    }
}
