<?php

namespace SD6Production\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  /*Supprimer un element : advert, image, member ou category*/
  public function deleteAction(Request $request, )
  {
    $em = $this->getDoctrine()->getManager();

    $user = $em->getRepository('SD6ProductionAppBundle:Advert')->find($numElement);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($elementDelete === null) {
      throw new NotFoundHttpException("Element d'id ".$numElement." n'existe pas.");
    }else{
      $em->remove($elementDelete);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }
}
