<?php

namespace SD6Production\PopupInfosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  public function indexAction()
  {
    return $this->render('SD6ProductionPopupInfosBundle:Default:index.html.twig');
  }

  public function popupInfosAction()
  {
    $title = 'test titre';
    $content = 'contenu test ...';
    return $this->render('SD6ProductionPopupInfosBundle:Default:popup-pinned.html.twig', array(
      'title' => $title,
      'content' => $content
    ));
  }
}
