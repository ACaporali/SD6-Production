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
    //Récupère les 3 dernières annonces
    $em = $this->getDoctrine()->getManager();
    $listeAnnonces = $em->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceNb(3);

    return $this->render('SD6ProductionAppBundle:Default:index.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }
  public function productionsAction()
  {
    //Récupère toutes les productions
    $em = $this->getDoctrine()->getManager();
    $listeProductions = $em ->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceCategories('Productions');

    //Regarde si il y a des production épinglés (productions en haut de page)
    $productionsEpingle = [];
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
    //Récupère tous les membres de l'équipe
    $em = $this->getDoctrine()->getManager();
    $listeMembres = $em->getRepository('SD6ProductionAppBundle:Membre')->findAll();

    return $this->render('SD6ProductionAppBundle:Default:equipe.html.twig', array(
      'listeMembres' => $listeMembres,
    ));
  }

  public function actualitesAction()
  {
    //Récupère toutes les actualités
    $em = $this->getDoctrine()->getManager();
    $listeAnnonces = $em ->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceCategories('Actualites');

    return $this->render('SD6ProductionAppBundle:Default:actualites.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }

  public function photosAction()
  {
    //Récupère les images de la galerie
    $em = $this->getDoctrine()->getManager();
    $listeImageGalerie = $em->getRepository('SD6ProductionAppBundle:Image')->getImageGalerie();

    return $this->render('SD6ProductionAppBundle:Default:photos.html.twig', array(
      'listeImageGalerie' => $listeImageGalerie,
    ));
  }

  public function castingAction()
  {
    //Récupère toutes annonces de casting
    $em = $this->getDoctrine()->getManager();
    $listeAnnonces = $em->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceCategories('Casting');

    return $this->render('SD6ProductionAppBundle:Default:casting.html.twig', array(
      'listeAnnonces' => $listeAnnonces,
    ));
  }

  public function detailsAnnonceAction($typeAnnonce, $slugAnnonce)
  {
    $em = $this->getDoctrine()->getManager();

    //Récupère l'annonce à afficher
    $annonce = $em->getRepository('SD6ProductionAppBundle:Annonce')->findOneBySlug($slugAnnonce);
    $id = $annonce->getId();

    //Récupère l'annonce précédente et suivante
    $annoncePrecedente = $em->getRepository('SD6ProductionAppBundle:Annonce')->findOneById($id - 1);
    $annonceSuivante = $em->getRepository('SD6ProductionAppBundle:Annonce')->findOneById($id + 1);

    return $this->render('SD6ProductionAppBundle:Default:detail.html.twig', array(
      'annonce' => $annonce,
      'annoncePrecedente' => $annoncePrecedente,
      'annonceSuivante' => $annonceSuivante
    ));
  }

  public function categorieAction()
  {
    //Récupère toutes les catégories
    $em = $this->getDoctrine()->getManager();

    $listeCategories = $em->getRepository('SD6ProductionAppBundle:Categorie')->findAll();

    return $this->render('SD6ProductionAppBundle:Default:categorie.html.twig', array(
      'listeCategories' => $listeCategories,
    ));
  }

  public function sideBarAction($limite)
  {
    //Récupère les dernières productions
    $em = $this->getDoctrine()->getManager();
    $listeProductions = $em ->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceNbAvecCategorie($limite, 'Productions');

    //Récupère les dernières actualités
    $em = $this->getDoctrine()->getManager();
    $listeActualites = $em ->getRepository('SD6ProductionAppBundle:Annonce')->getAnnonceNbAvecCategorie($limite, 'Actualites');

    return $this->render('SD6ProductionAppBundle:Default:side-bar.html.twig', array(
      'listeProductions' => $listeProductions,
      'listeActualites' => $listeActualites
    ));
  }
}
