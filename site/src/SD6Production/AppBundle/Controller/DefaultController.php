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
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

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

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
        } else if ($formMembre->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Membre bien enregistrée.');

            return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
           
        }else if ($formCategorie->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée.');

            return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

        }else if ($formImage->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée.');

            return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
        }

	    return $this->render('SD6ProductionAppBundle:Default:ajouter.html.twig', array(
	      'formAnnonce' => $formAnnonce->createView(),
          'formMembre' => $formMembre->createView(),
          'formCategorie' => $formCategorie->createView(),
          'formImage' => $formImage->createView(),
	    ));
    }

    public function editerannonceAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function supprimerannonceAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function productionsAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function equipeAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:equipe.html.twig');
    }

    public function actualitesAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
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
        return $this->render('SD6ProductionAppBundle:Default:index.html.twig');
    }

    public function contactAction()
    {
        return $this->render('SD6ProductionAppBundle:Default:contact.html.twig');
    }
}
