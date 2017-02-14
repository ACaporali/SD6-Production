<?php

namespace SD6Production\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Annonce;
use SD6Production\AppBundle\Form\AnnonceType;
use SD6Production\AppBundle\Entity\Membre;
use SD6Production\AppBundle\Form\MembreType;
use SD6Production\AppBundle\Entity\Categorie;
use SD6Production\AppBundle\Form\CategorieType;
use SD6Production\AppBundle\Entity\Image;
use SD6Production\AppBundle\Form\ImageType;

class ActionController extends Controller
{
  /*Ajouter un element : annonce, image, membre et categorie*/
  public function ajouterAction(Request $request){
    $annonce = new Annonce();
    $formAnnonce = $this->get('form.factory')->create(new AnnonceType(), $annonce);

    $membre = new Membre();
    $formMembre = $this->get('form.factory')->create(new MembreType(), $membre);

    $categorie = new Categorie();
    $formCategorie = $this->get('form.factory')->create(new CategorieType(), $categorie);

    $image = new Image();
    $formImage = $this->get('form.factory')->create(new ImageType(), $image);

    $formAnnonce->handleRequest($request);
    $formMembre->handleRequest($request);
    $formCategorie->handleRequest($request);
    $formImage->handleRequest($request);

    if ($formAnnonce->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($annonce);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    } else if ($formMembre->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($membre);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Membre enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }else if ($formCategorie->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($categorie);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Catégorie enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }else if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAppBundle:Action:ajouter.html.twig', array(
      'formAnnonce' => $formAnnonce->createView(),
      'formMembre' => $formMembre->createView(),
      'formCategorie' => $formCategorie->createView(),
      'formImage' => $formImage->createView(),
    ));
  }

  /*Editer et supprimer annonce*/
  public function editerAnnonceAction(Request $request, $slugAnnonce)
  {
    $em = $this->getDoctrine()->getManager();
    $annonce = $em->getRepository('SD6ProductionAppBundle:Annonce')->findOneBySlug($slugAnnonce);

    $formAnnonce = $this->get('form.factory')->create(new AnnonceType(), $annonce);
    $formAnnonce->handleRequest($request);

    if ($formAnnonce->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($annonce);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Annonce modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAppBundle:Action:editer.html.twig', array(
      'formAnnonce' => $formAnnonce->createView(),
      'annonce' => $annonce,
    ));
  }

  /*Editer image*/
  public function editerImageAction(Request $request, $idImage)
  {
    $em = $this->getDoctrine()->getManager();
    $image = $em->getRepository('SD6ProductionAppBundle:Image')->findOneById($idImage);

    $formImage = $this->get('form.factory')->create(new ImageType(), $image);
    $formImage->handleRequest($request);

    if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAppBundle:Action:editer.html.twig', array(
      'formImage' => $formImage->createView(),
      'image' => $image,
    ));
  }


  /*Editer membre*/
  public function editerMembreAction(Request $request, $idMembre)
  {
    $em = $this->getDoctrine()->getManager();
    $membre = $em->getRepository('SD6ProductionAppBundle:Membre')->findOneById($idMembre);

    $formMembre = $this->get('form.factory')->create(new MembreType(), $membre);
    $formMembre->handleRequest($request);

    if ($formMembre->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($membre);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Membre modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAppBundle:Action:editer.html.twig', array(
      'formMembre' => $formMembre->createView(),
      'membre' => $membre,
    ));
  }


  /*Editer categorie*/
  public function editerCategorieAction(Request $request, $idCategorie)
  {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('SD6ProductionAppBundle:Categorie')->findOneById($idCategorie);

    $formCategorie = $this->get('form.factory')->create(new CategorieType(), $categorie);
    $formCategorie->handleRequest($request);

    if ($formCategorie->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($categorie);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Categorie modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAppBundle:Action:editer.html.twig', array(
      'formCategorie' => $formCategorie->createView(),
      'categorie' => $categorie,
    ));
  }

  /*Supprimer un element : annonce, image, membre ou categorie*/
  public function supprimerAction($typeElement, $numElement, Request $request)
  {
    //Regarde le type d'Entity à supprimer
    if ($typeElement == 'annonce') {
      $elementSupp = $em->getRepository('SD6ProductionAppBundle:Annonce')->find($numElement);
    }elseif ($typeElement == 'equipe') {
      $elementSupp = $em->getRepository('SD6ProductionAppBundle:Membre')->find($numElement);
    }elseif ($typeElement == 'galerie-photos') {
      $elementSupp = $em->getRepository('SD6ProductionAppBundle:Image')->find($numElement);
    }elseif ($typeElement == 'categorie') {
      $elementSupp = $em->getRepository('SD6ProductionAppBundle:Categorie')->find($numElement);
    }

    $session = $request->getSession();
    $session->set('numero', $numElement);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($elementSupp === null) {
      throw new NotFoundHttpException("Element d'id ".$numElement." n'existe pas.");
    }else{
      $em->remove($elementSupp);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }
}
