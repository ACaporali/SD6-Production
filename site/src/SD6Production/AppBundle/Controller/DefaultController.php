<?php

namespace SD6Production\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SD6Production\AppBundle\Entity\Annonce;
use SD6Production\AppBundle\Form\AnnonceType;
use SD6Production\AppBundle\Entity\Membre;
use SD6Production\AppBundle\Form\MembreType;
use SD6Production\AppBundle\Entity\Categorie;
use SD6Production\AppBundle\Form\CategorieType;
use SD6Production\AppBundle\Entity\Image;
use SD6Production\AppBundle\Form\ImageType;

class DefaultController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $listeAnnonces = $em->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceNb(3);

    return $this->render('SD6ProductionAppBundle:Default:index.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }
  public function productionsAction()
  {
    $listeProductions = $this->getDoctrine()
    ->getManager()
    ->getRepository('SD6ProductionAppBundle:Annonce')
    ->getAnnonceWithCategories('Production');

    foreach ($listeProductions as $key => $production) {
      if ($production->getEpingle() == 1 ) {
        $productionsEpingle[] = $production;
      }
    }

    return $this->render('SD6ProductionAppBundle:Default:productions.html.twig', array(
      'listeProductions' => $listeProductions,
      'productionsEpingle' => $productionsEpingle,
    ));
  }

  public function prestationsAction()
  {
    return $this->render('SD6ProductionAppBundle:Default:prestations.html.twig');
  }

  public function equipeAction()
  {
    $em = $this->getDoctrine()->getManager();
    $listeMembres = $em->getRepository('SD6ProductionAppBundle:Membre')->findAll();

    return $this->render('SD6ProductionAppBundle:Default:equipe.html.twig', array(
      'listeMembres' => $listeMembres,
    ));
  }

  public function actualitesAction()
  {
    $listeAnnonces = $this->getDoctrine()
    ->getManager()
    ->getRepository('SD6ProductionAppBundle:Annonce')
    ->getAnnonceWithCategories('Actualite');

    return $this->render('SD6ProductionAppBundle:Default:actualites.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }

  public function photosAction()
  {
    $listeImageGalerie = $this->getDoctrine()
    ->getManager()
    ->getRepository('SD6ProductionAppBundle:Image')
    ->getImageGalerie();
    return $this->render('SD6ProductionAppBundle:Default:photos.html.twig', array(
      'listeImageGalerie' => $listeImageGalerie,
    ));
  }

  public function recrutementsAction()
  {
    $listeAnnonces = $this->getDoctrine()
    ->getManager()
    ->getRepository('SD6ProductionAppBundle:Annonce')
    ->getAnnonceWithCategories('Recrutement');

    return $this->render('SD6ProductionAppBundle:Default:recrutements.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }

  public function contactAction()
  {
    return $this->render('SD6ProductionAppBundle:Default:contact.html.twig');
  }

  public function detailsAnnonceAction($typeAnnonce, $slugAnnonce)
  {
    $em = $this->getDoctrine()->getManager();

    $annonce = $em->getRepository('SD6ProductionAppBundle:Annonce')->findOneBySlug($slugAnnonce)
    ;

    return $this->render('SD6ProductionAppBundle:Default:detail.html.twig', array(
      'annonce' => $annonce,
    ));
  }
}
