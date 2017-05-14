<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Advert;
use SD6Production\AppBundle\Form\AdvertType;


class AdvertController extends Controller
{
  public function advertAction()
  {
    //Récupère toutes les catégories
    $em = $this->getDoctrine()->getManager();

    $adverts = $em->getRepository('SD6ProductionAppBundle:Advert')->findAll();

    return $this->render('SD6ProductionAdminBundle:Advert:annonce.html.twig', array(
      'adverts' => $adverts,
    ));
  }

  /*Ajouter advert*/
  public function addAction(Request $request){
    $advert = new Advert();
    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);

    $formAdvert->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }

    return $this->render('SD6ProductionAdminBundle:Advert:ajouter.html.twig', array(
      'formAdvert' => $formAdvert->createView(),
    ));
  }

  /*Editer advert*/
  public function editeAction(Request $request, $idAdvert)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('SD6ProductionAppBundle:Advert')->findOneById($idAdvert);

    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);
    $formAdvert->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Advert:editer.html.twig', array(
      'formAdvert' => $formAdvert->createView(),
      'advert' => $advert,
    ));
  }

  /*Supprimer une advert*/
  public function deleteAction($idAdvert, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('SD6ProductionAppBundle:Advert')->find($idAdvert);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($idAdvert === null) {
      throw new NotFoundHttpException("Element d'id ".$idAdvert." n'existe pas.");
    }else{
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }
}
