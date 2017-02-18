<?php

namespace SD6Production\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SD6ProductionSocialBundle:Default:index.html.twig');
    }
}
