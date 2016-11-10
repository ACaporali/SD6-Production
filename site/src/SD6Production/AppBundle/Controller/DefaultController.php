<?php

namespace SD6Production\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }
}
