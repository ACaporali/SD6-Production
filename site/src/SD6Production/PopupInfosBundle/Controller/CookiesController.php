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
    $days = $request->get('days');

    $cookies = $request->cookies;

    $cookie = new Cookie($name, $value, (time() + 3600 * 24 * $days), '/');
    $response = new Response();
    $response->headers->setCookie($cookie);
    $response->send();
    return $response;
  }
}
