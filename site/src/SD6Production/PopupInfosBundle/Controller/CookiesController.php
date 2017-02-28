<?php

namespace SD6Production\PopupInfosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CookiesController extends Controller
{
  public function createCookiesAction(Request $request)
  {
    // Si requête AJAX
    if(!$request->isXMLHttpRequest() && !$this->get('kernel')->isDebug()) {
      throw new NotFoundHttpException('Cette page ne peut être accédée directement.');
    }

    $name = $request->get('name');
    $value = $request->get('value');

    $cookies = $request->cookies;

    /*if ($cookies->has($name))
    {
      return $this->render('SD6ProductionPopupInfosBundle:Cookies:cookies_ok.html.twig');
    }else{
    }*/

    $cookie = new Cookie($name, $value, (time() + 3600 * 24 * 7), '/');
    $response = new Response();
    $response->headers->setCookie($cookie);
    $response->send();

    return new Response();
  }

  public function cguCookiesAction(Request $request)
  {
    return $this->render('SD6ProductionPopupInfosBundle:Cookies:cgu.html.twig');
  }
}
