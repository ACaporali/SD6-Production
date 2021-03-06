<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Advert;
use SD6Production\AppBundle\Entity\AdvertCasting;
use SD6Production\AppBundle\Form\AdvertType;
use Symfony\Component\HttpFoundation\Response;


class AdvertController extends Controller
{
  public function advertAction()
  {
    //Récupère toutes les catégories
    $em = $this->getDoctrine()->getManager();

    $adverts = $em->getRepository('SD6ProductionAppBundle:Advert')->getAdvertAllOrderBy('date');

    if(empty($adverts)){
      throw new NotFoundHttpException("Oups, no advert founded");
    }

    return $this->render('SD6ProductionAdminBundle:Advert:annonce.html.twig', array(
      'adverts' => $adverts,
    ));
  }

  /*Ajouter advert*/
  public function addAction(Request $request, $type){
    if ($type == 'autre') {
      $advert = new Advert();
    }else{
      $advert = new AdvertCasting();
    }

    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);

    $formAdvert->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_advert_index'));

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

    if(!isset($idAdvert) || empty($advert)){
      throw new NotFoundHttpException("Oups, not found advert #".$idAdvert);
    }

    $formAdvert = $this->get('form.factory')->create(new AdvertType(), $advert);
    $formAdvert->handleRequest($request);

    if ($formAdvert->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_admin_advert_index'));
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
    if(!isset($idAdvert) || empty($advert)){
      throw new NotFoundHttpException("Oups, not found advert #".$idAdvert);
    }else{
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return new Response();
    }
  }
}
